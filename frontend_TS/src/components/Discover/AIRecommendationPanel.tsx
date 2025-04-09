import React, { useState } from 'react';
import { API_BASE_URL } from '../../config';
import './AIRecommendationPanel.css';

const AIRecommendationPanel: React.FC = () => {
  const [isLoading, setIsLoading] = useState<boolean>(false);
  const [selectedFile, setSelectedFile] = useState<File | null>(null);
  const [previewUrl, setPreviewUrl] = useState<string | null>(null);
  const [error, setError] = useState<string | null>(null);

  const handleFileChange = (event: React.ChangeEvent<HTMLInputElement>) => {
    const file = event.target.files?.[0];
    if (!file) return;
    
    // Check file size (5MB limit)
    if (file.size > 5 * 1024 * 1024) {
      setError('File size exceeds the 5MB limit');
      return;
    }
    
    setError(null);
    setSelectedFile(file);
    
    // Create preview
    const reader = new FileReader();
    reader.onloadend = () => {
      setPreviewUrl(reader.result as string);
    };
    reader.readAsDataURL(file);
  };

  const handleSubmit = async (event: React.FormEvent) => {
    event.preventDefault();
    
    if (!selectedFile) {
      setError('Please select an image');
      return;
    }
    
    setIsLoading(true);
    setError(null);
    
    try {
      // First check if the API is accessible at all - this is just a diagnostic step
      try {
        const testResponse = await fetch(`${API_BASE_URL}/api/test`);
        console.log('Test API response:', testResponse.status, await testResponse.text());
      } catch (err) {
        console.error('API test failed:', err);
      }
      
      // Convert file to base64 for sending to API
      const reader = new FileReader();
      reader.readAsDataURL(selectedFile);
      
      reader.onload = async () => {
        try {
          // Get base64 string without the prefix
          const base64String = (reader.result as string).split(',')[1];
          
          // Create a simple JSON payload instead of FormData
          const payload = JSON.stringify({
            image_base64: base64String,
            prompt: 'Can you recommend clothing with similar style?'
          });
          
          console.log('Sending request to:', `${API_BASE_URL}/api/ai-recommend`);
          
          const response = await fetch(`${API_BASE_URL}/api/ai-recommend`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: payload,
          });
          
          console.log('Response status:', response.status);
          
          if (!response.ok) {
            const errorText = await response.text();
            console.error('Error response:', errorText);
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          
          const data = await response.json();
          console.log('Response data:', data);
          
          if (data.success) {
            // Redirect to the AI recommendation page
            window.location.href = `${API_BASE_URL}/ai-recommendation/${data.recommendation_id}`;
          } else {
            setError(data.error || 'Failed to get recommendations');
            setIsLoading(false);
          }
        } catch (err) {
          console.error('Request error:', err);
          setError('Error submitting request: ' + (err instanceof Error ? err.message : 'Unknown error'));
          setIsLoading(false);
        }
      };
      
      reader.onerror = () => {
        setError('Error reading file');
        setIsLoading(false);
      };
      
    } catch (err) {
      console.error('Request error:', err);
      setError('Error submitting request: ' + (err instanceof Error ? err.message : 'Unknown error'));
      setIsLoading(false);
    }
  };

  // Add support for drag and drop
  const handleDragOver = (e: React.DragEvent<HTMLDivElement>) => {
    e.preventDefault();
    e.stopPropagation();
  };

  const handleDrop = (e: React.DragEvent<HTMLDivElement>) => {
    e.preventDefault();
    e.stopPropagation();
    
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      const file = e.dataTransfer.files[0];
      if (file.type.match('image.*')) {
        // Reuse the file change logic
        handleFileChange({ target: { files: e.dataTransfer.files } } as unknown as React.ChangeEvent<HTMLInputElement>);
      } else {
        setError('Please upload an image file');
      }
    }
  };

  return (
    <div className="ai-recommendation-panel">
      <h3 className="ai-recommendation-title">Ask AI for Similar Style Recommendations</h3>
      
      <form onSubmit={handleSubmit} className="ai-recommendation-form">
        <div 
          className="ai-image-upload-area"
          onDragOver={handleDragOver}
          onDrop={handleDrop}
        >
          {previewUrl ? (
            <div className="ai-image-preview-container">
              <img src={previewUrl} alt="Preview" className="ai-image-preview" />
              <button 
                type="button" 
                className="ai-remove-image" 
                onClick={() => {
                  setSelectedFile(null);
                  setPreviewUrl(null);
                }}
              >
                ✕
              </button>
            </div>
          ) : (
            <div className="ai-upload-placeholder" onClick={() => document.getElementById('ai-file-input')?.click()}>
              <div className="ai-upload-icon">📷</div>
              <p>Click to upload an image</p>
              <p className="ai-upload-hint">or drag and drop</p>
            </div>
          )}
          <input 
            type="file" 
            id="ai-file-input"
            accept="image/*" 
            className="ai-file-input" 
            onChange={handleFileChange}
          />
        </div>
        
        {error && <div className="ai-error">{error}</div>}
        
        <button 
          type="submit" 
          className="ai-submit-button" 
          disabled={isLoading || !selectedFile}
        >
          {isLoading ? 'Processing...' : 'Get Style Recommendations'}
        </button>
      </form>
    </div>
  );
};

export default AIRecommendationPanel;