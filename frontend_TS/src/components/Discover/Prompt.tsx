import React, { useState, useRef, useEffect } from 'react';
import ImageUploader from './ImgUploader';
import ImagePreview from './ImgPreview';
import ResultsContainer from './ResultContainer';
import { analyzeFashionImage } from '../../services/ApiService';
import { AIResponse } from '../../models/ApiResponseModel';


/*
 * This component is used to analyze fashion images and provide AI-generated suggestions.
 * 
 * @returns FashionAnalyzer component that allows users to upload a fashion image, enter a prompt, and receive AI-generated suggestions.
 */
const FashionAnalyzer = () => {

    // State variables for stroing and updating values in the component(selectedFile, previewImage, prompt, isLoading, results, showResults).
    const [selectedFile, setSelectedFile] = useState<File | null>(null);
    const [previewUrl, setPreviewUrl]     = useState<string>('');
    const [prompt, setPrompt]             = useState<string>('');
    const [isLoading, setIsLoading]       = useState<boolean>(false);             // Loading state for the API call.
    const [results, setResults]           = useState<AIResponse | null>(null);
    const [showResults, setShowResults]   = useState<boolean>(false);             // State to control the visibility of the results.
    const uploadContainerRef              = useRef<HTMLDivElement>(null);         // Ref to the upload container for applying styles.



    /*
     * This function handles the selection of an image file and updates the preview URL(Image).
     * 
     * @param file - The selected image file.
     * @param imageUrl - The URL of the selected image for preview.
     */
    const handleImageSelect = (file: File, imageUrl: string) => {

        setSelectedFile(file);
        setPreviewUrl(imageUrl);

        // Reset results when a new image is selected
        setResults(null);
        setShowResults(false);
      };



    /*
     * This function handles the removal of the selected image and resets the preview URL.
     */
    const handleRemoveImage = () => {

        //Reset selected file and preview URL(Image)
        setSelectedFile(null);
        setPreviewUrl('');
        
        //Reset the upload container position if results are hidden.
        if (!showResults && uploadContainerRef.current) {
        uploadContainerRef.current.style.transform = 'translateY(0)';
        }
    };



    /*
     * This function handles the change event of the prompt input field and updates the prompt state.
     * 
     * @param e - The event object from the input change event.
     */
    const handlePromptChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setPrompt(e.target.value);
    };


    //Checking if we can submit. Either have a file or a valid prompt.
    const isPromptValid = prompt.trim().length > 0;
    const canSubmit     = selectedFile !== null || isPromptValid;


    /*
     * This function handles the submission of the image and prompt to the API for analysis.
     * 
     * @returns Results of the analysis or an error message if the submission fails.
     */
    const handleSubmit = async () => {
        
        //Making sure there is at least a valid prompt.
        if (!isPromptValid) return;
        

        try {
            setIsLoading(true);
            setShowResults(true);
            

            //Push down effect to the upload container (if results are shown).
            if (uploadContainerRef.current) {
                uploadContainerRef.current.style.transform = 'translateY(20px)';
            }
            

            //Calling API to analyze the image and get results. (Implemented in ApiService.ts)
            const response = await analyzeFashionImage(selectedFile, prompt);
            
            //Checking if the response was successful.
            if (response.success) {
                setResults(response.data);

            } else {
                console.error('(Prompt.tsx) Error analyzing image:', response.error);
                alert('Sorry, there was an error analyzing your image. Please try again. (Prompt.tsx)');
                
            }

        } catch (error) {
        console.error('(Prompt.tsx) Submission error:', error);
        alert('An unexpected error occurred. Please try again. (Prompt.tsx)');

        } finally {
        //Turn off loading state.
        setIsLoading(false);
        }
    };


    //Scrolling to results when available.
    useEffect(() => {

        //Check if results are shown and loading is finished.
        if (showResults && !isLoading) {
        
        //Pure JS, but needed it for the scrollIntoView effect.
        //This is because the results container is not in the DOM until the API call is finished.
        //'querySelector()' - returns the first element that matches a CSS selector.
        const resultsElement = document.querySelector('.fai-results-container');
            
            //Check if the results element is available and scroll to it.
            //This is to make sure that the results are shown in the viewport.
            if (resultsElement) {
                resultsElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }, [showResults, isLoading]);


    return (

        <div className="fai-app-container">


            {/* Results container */}
            {/* This code works with useEffect() to scroll to the results when available. */}
            {/* The results container is hidden until the API call is finished. */}
            <ResultsContainer isLoading={isLoading} results={results} />
            

            {/* Upload container */}
            <div className="fai-upload-container" ref={uploadContainerRef}>

                <h2 className="fai-upload-title">Upload an Image</h2>
                
                {/* Image uploader component */}
                {previewUrl ? (
                    <ImagePreview imageUrl={previewUrl} onRemove={handleRemoveImage} />
                    ) : (
                    <ImageUploader onImageSelect={handleImageSelect} />
                )}
                
                    
    
                 {/* Prompt input field and submit button */}
                <div className="fai-prompt-container">
                    <input 
                        type="text" 
                        className="fai-prompt-input" 
                        placeholder="Ask something about this fashion item (e.g., 'Where can I buy this?' or 'Suggest styling ideas')"
                        value={prompt}
                        onChange={handlePromptChange}
                    />
                    <button className="fai-button" onClick={handleSubmit} disabled={!canSubmit}> Generate Suggestions </button>
                </div>

            </div>
        </div>
    );
};

export default FashionAnalyzer;
