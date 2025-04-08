import React, { useState, useRef, DragEvent } from "react";
import { MAX_FILE_SIZE } from "../../config";
import { ImageUploaderProps } from "../../models/PromptingModel";


/*
 * This component allows users to upload images by dragging and dropping or clicking to select a file.
 * This file contains some DOM events and elements in React way.
 *
 * @param param0 - The props for the ImageUploader component. (Located in the models/PromptingModel.ts)
 * @returns ImageUploader component.
 */
const ImageUploader = ({ onImageSelect }: ImageUploaderProps) => {


  //State to manage the dragging state of the upload area.(Changes the background color when dragging)
  const [isDragging, setIsDragging] = useState<boolean>(false);
  const fileInputRef = useRef<HTMLInputElement>(null);  //Reference to access the file input element.


  /*
   * Function to handle the drag over event for the upload area.
   */
  const handleDragOver = (e: DragEvent<HTMLDivElement>) => {
    e.preventDefault();
    setIsDragging(true);
  };

  const handleDragLeave = () => {
    setIsDragging(false);
  };

  const handleDrop = (e: DragEvent<HTMLDivElement>) => {
    e.preventDefault();
    setIsDragging(false);

    const files = e.dataTransfer.files;
    if (files.length > 0 && files[0].type.match("image.*")) {
      handleFileSelection(files[0]);
    }
  };




  /*
   * Function to handle file input change event.
   */
  const handleFileInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files.length > 0) {
      handleFileSelection(e.target.files[0]);
    }
  };

  const handleFileSelection = (file: File) => {
    if (file.size > MAX_FILE_SIZE) {
      alert("File is too large. Maximum size is 5MB.");
      return;
    }

    const reader = new FileReader();
    reader.onload = (e) => {
      if (e.target && typeof e.target.result === "string") {
        onImageSelect(file, e.target.result);
      }
    };
    reader.readAsDataURL(file);
  };



  /*
   * Function to handle click event on the upload area.
   */
  const handleClick = () => {
    if (fileInputRef.current) {
      fileInputRef.current.click();
    }
  };


  //Render the image uploader component.
  return (
    <div
      className  ={`fai-upload-area ${isDragging ? "dragging" : ""}`}
      onDragOver ={handleDragOver}
      onDragLeave={handleDragLeave}
      onDrop     ={handleDrop}
      onClick    ={handleClick}

      style      ={{
        backgroundColor: isDragging ? "rgba(245, 241, 230, 0.7)" : "#fff",
        borderColor: "#000",
      }}>

      <div className="fai-upload-icon">📷</div>
      <p className="fai-upload-text">
        Drag and drop an image here or click to browse
      </p>

      <input
        type="file"
        className="fai-file-input"
        ref={fileInputRef}
        accept="image/*"
        onChange={handleFileInputChange}
      />
    </div>
  );
};

export default ImageUploader;
