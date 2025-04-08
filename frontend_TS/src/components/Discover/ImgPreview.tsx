//! This file is a uploading image component for a part of the Ai prompting page.

import { ImagePreviewProps } from "../../models/PromptingModel";

/*
 * This component is used to preview the uploaded image and provide a button to remove it.
 * 
 * @param param0 - The props for the ImagePreview component. (Located in the models/PromptingModel.ts)
 * @returns ImagePreview component.
 */
const ImagePreview = ({ imageUrl, onRemove }: ImagePreviewProps) => {
  return (
    <div className="fai-preview-container">
      <img className="fai-image-preview" src={imageUrl} alt="Preview" />

      <button
        onClick={onRemove}
        className="fai-button"
        style={{ backgroundColor: "#666" }}
      >
        Remove Image
      </button>
    </div>
  );
};

export default ImagePreview;
