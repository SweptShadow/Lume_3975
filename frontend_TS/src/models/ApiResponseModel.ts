//! This file defines the shape of the data returned from the API for fashion-related requests.

//API Response
export interface ApiResponse {
  success: boolean;
  data: AIResponse;
  error?: string;       //This nullable field.
}


// Union type for different response types
export type AIResponse = SimilarItemsResult | StyleAnalysis;

//Model for similar items result. This interface is expected to be returned from the API response.
export interface SimilarItemsResult {
  items: SimilarItem[];
}

//Model for finding similar items. This interface is expected to be returned from the API response.
export interface SimilarItem {
  id: string;
  name: string;
  description: string;
  price: string;
  image: string;
  shopUrl: string;
}

//Model for style analysis. This interface is expected to be returned from the API response.
export interface StyleAnalysis {
  description: string;
  recommendations: string[];
  alternativeStyles: StyleSuggestion[];
}


//Model for style suggestions. This interface is expected to be returned from the API response.
export interface StyleSuggestion {
  id: string;
  name: string;
  description: string;
  image: string;
}