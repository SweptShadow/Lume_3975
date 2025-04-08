import { API_BASE_URL, API_ENDPOINTS } from "../config";
import { ApiResponse, AIResponse } from "../models/ApiResponseModel";


/*
 * Createing FormData object for the fashion analysis request.
 *
 * @param image - The image file to be analyzed(optional).
 * @param prompt - The text prompt for analysis
 * @returns FormData object with the request data
 */
const createFashionRequestData = (image: File | null, prompt: string): FormData => {

  //FormDat() is used to send form data in a multipart/form-data format. Useful for sending files in one request.
  const formData = new FormData();

  formData.append("prompt", prompt);

  //Appending the image file if provided.
  if (image) {
    formData.append("image", image);
  }

  return formData;
};


/*
 * Sending the analysis request to the API (This is only for sending the request to the API).
 *
 * @param requestData - FormData containing the request data.
 * @returns Promise resolving to the fetch Response.
 */
const sendFashionRequest = async (requestData: FormData): Promise<Response> => {

  return fetch(`${API_BASE_URL}${API_ENDPOINTS.FASHION_ANALYSIS}`, {

    method: "POST",
    body: requestData,
    headers: {
      Accept: "application/json",
    },
    //Adding the timeout for the request. (Used to abort the request if it takes too long).
    signal: AbortSignal.timeout(30000),
  });
};


/*
 * Processes the API response and handles error cases. (Includes parsing the JSON response).
 * 
 * @param response - The fetch Response object
 * @returns Promise resolving to a properly formatted ApiResponse
 */
const processFashionResponse = async (response: Response): Promise<ApiResponse> => {

  if (!response.ok) {
    console.error("(ApiSevice.ts) Error response:", response.status, response.statusText);
    return handleErrorResponse(response);
  }


  try {

    //Parsing the JSON response from the server.
    const data = await response.json();


    if (!data) {
      return {
        success: false,
        data: {} as AIResponse,
        error: "Invalid response from server.",
      };

    }

    //Return if the response is not empty and return data as AIResponse(Check ApiResponseModel.ts).
    return {
      success: true,
      data: data as AIResponse,
    };

  } catch (jsonError) {
    
    console.error("Error parsing JSON response:", jsonError);
    return {
      success: false,
      data: {} as AIResponse,
      error: "Invalid response format from server.",
    };
  }
};

/*
 * Handles different types of error responses based on status codes
 * @param response - The error Response object
 * @returns ApiResponse with appropriate error message
 */
const handleErrorResponse = (response: Response): ApiResponse => {
  const statusCode = response.status;

  const errorMessages: Record<number, string> = {
    413: "The image file is too large. Please use a smaller image.",
    415: "Unsupported file format. Please upload a valid image file.",
    429: "Too many requests. Please try again later.",
  };

  const errorMessage =
    errorMessages[statusCode] ||
    `Server error: ${statusCode}. Please try again later.`;

  return {
    success: false,
    data: {} as AIResponse,
    error: errorMessage,
  };
};

/*
 * Main function to analyze fashion images and/or text prompts
 * @param image - The image file to be analyzed (optional)
 * @param prompt - The prompt to be sent with the image
 * @returns Promise resolving to ApiResponse with the analysis results
 */
export const analyzeFashionImage = async (
  image: File | null,
  prompt: string
): Promise<ApiResponse> => {
  try {
    const requestData = createFashionRequestData(image, prompt);
    const response = await sendFashionRequest(requestData);
    return await processFashionResponse(response);
  } catch (error) {
    console.error("Fashion analysis error:", error);

    if (error instanceof DOMException && error.name === "AbortError") {
      return {
        success: false,
        data: {} as AIResponse,
        error: "Request timed out. Please try again later.",
      };
    }

    return {
      success: false,
      data: {} as AIResponse,
      error: "Sorry, something went wrong. Please try again later.",
    };
  }
};
