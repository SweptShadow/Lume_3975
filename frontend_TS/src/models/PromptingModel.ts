//! This file defines properties 
import { SimilarItem } from '../models/ApiResponseModel';
import { StyleAnalysis as StyleAnalysisType } from '../models/ApiResponseModel';
import { AIResponse} from '../models/ApiResponseModel';


//This model defines display properties for the image preview and delete functionality.
export interface ImagePreviewProps {
    imageUrl: string;
    onRemove: () => void;
}


//This model defines the properties for the image uploader component, including a callback function for when an image is selected.
export interface ImageUploaderProps {
    onImageSelect: (file: File, previewUrl: string) => void;
}


//This model defines similar items properties for displaying a list of similar items found from the API response.
export interface SimilarItemsProps {
    items: SimilarItem[];
}


//This model defines properties for the style analysis component, including the analysis data.
export interface StyleAnalysisProps {
    analysis: StyleAnalysisType;
}

//This model defines properties for the results container component, including loading state and results data from api response.
export interface ResultsContainerProps {
    isLoading: boolean;
    results: AIResponse | null;
}