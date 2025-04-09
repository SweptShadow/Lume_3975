//! This file is for configuration for backend API

//Base URL for Laravel backend (handles both DB and AI requests)
export const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || "http://127.0.0.1:8000";

//API endpoints
export const API_ENDPOINTS = {
    // OOTD endpoints (From DB)
    OOTD_POSTS: '/ootd/posts',  
    OOTD_POST_DETAIL: '/ootd/post',
    
    //AI Fashion endpoints (From AI)
    FASHION_ANALYSIS: '/api/analyze',
    
    //GPT-4o AI recommendations endpoint
    AI_RECOMMENDATIONS: '/api/ai-recommend',
};

//Limits uploaded files for sending image to Ai.
export const MAX_FILE_SIZE = 5 * 1024 * 1024;

