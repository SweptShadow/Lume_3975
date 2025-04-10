<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Style Recommendations</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #212529;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .title {
            font-size: 24px;
            font-weight: 600;
            color: #000;
        }
        .back-button {
            display: inline-block;
            padding: 10px 15px;
            background-color: #000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .content {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .loading {
            text-align: center;
            padding: 50px 0;
        }
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border-left-color: #000;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .error {
            color: #d9534f;
            text-align: center;
            padding: 30px;
        }
        /* Markdown styles */
        .markdown-content h1 { font-size: 24px; margin-top: 0; }
        .markdown-content h2 { font-size: 20px; margin-top: 25px; }
        .markdown-content h3 { font-size: 18px; }
        .markdown-content p { line-height: 1.6; }
        .markdown-content ul { padding-left: 20px; }
        .markdown-content li { margin-bottom: 5px; }
        .markdown-content strong { font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="title">AI Style Recommendations</h1>
            <a href="javascript:history.back()" class="back-button">Back to Discover</a>
        </div>
        
        <div class="content">
            <div class="loading">
                <div class="spinner"></div>
                <p>Loading recommendations...</p>
            </div>
            <div class="recommendation-content" style="display:none;"></div>
            <div class="error-message" style="display:none;"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recommendationId = {{ $id }};
            const loadingElement = document.querySelector('.loading');
            const contentElement = document.querySelector('.recommendation-content');
            const errorElement = document.querySelector('.error-message');
            
            console.log('Fetching recommendation ID:', recommendationId);
            
            // Fetch the recommendation
            fetch(`/api/ai-recommend/${recommendationId}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    loadingElement.style.display = 'none';
                    
                    if (data.success) {
                        // Convert markdown line breaks to <br> tags
                        const formattedContent = data.recommendations
                            .replace(/\n\n## /g, '<h2>')
                            .replace(/\n\n/g, '</p><p>')
                            .replace(/\n- \*\*(.*?)\*\*: (.*?)$/gm, '<br><strong>$1:</strong> $2')
                            .replace(/\n- (.*?)$/gm, '<br>• $1');
                            
                        contentElement.innerHTML = `<div class="markdown-content"><p>${formattedContent}</p></div>`;
                        contentElement.style.display = 'block';
                    } else {
                        // Display error message
                        errorElement.textContent = data.error || 'Failed to load recommendations';
                        errorElement.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    loadingElement.style.display = 'none';
                    errorElement.textContent = 'Error loading recommendations: ' + error.message;
                    errorElement.style.display = 'block';
                });
        });
    </script>
</body>
</html>