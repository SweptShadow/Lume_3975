<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Style Recommendations | Lume</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #212529;
        }
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .content-card {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        /* Better markdown styling */
        .recommendation-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #000;
        }
        .recommendation-intro {
            font-size: 16px;
            margin-bottom: 24px;
            color: #666;
        }
        .outfit-title {
            font-size: 18px;
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 8px;
            color: #000;
        }
        .outfit-item {
            margin-bottom: 4px;
        }
        .outfit-item strong {
            font-weight: 600;
            color: #222;
        }
        .outfit-section {
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #eee;
        }
        .where-to-shop {
            margin-top: 24px;
            padding-top: 12px;
            font-weight: 600;
        }
        .navbar-custom {
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 24px;
        }
        .footer {
            font-family: 'DM Serif Text', serif;
            width: 100%; /* Change from 100vw to 100% */
            height: auto;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            bottom: 0;
            left: 0;
            text-align: center;
            margin-top: 30px;
            padding: 15px 0;
            position: relative;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer-links {
            font-size: 0.9rem;
            color: #777;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Lume</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/discover">Discover</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ootd">OOTD</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">
        <div class="content-card">
            <div class="loading">
                <div class="spinner"></div>
                <p>Loading recommendations...</p>
            </div>
            <div class="recommendation-content" style="display:none;"></div>
            <div class="error-message text-danger" style="display:none;"></div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-inner">
            <p class="mb-0">© 2025 lumé</p>
            <div class="footer-links">
                Brian Diep A00959233 | Yujin Jeong | Dalraj Bains | Evan Vink
            </div>
        </div>
    </footer>

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
                        // Parse and format the recommendation text
                        let text = data.recommendations;
                        
                        // Extract title and intro
                        const titleMatch = text.match(/# (.*?)(?:\n|$)/);
                        const title = titleMatch ? titleMatch[1] : 'Style Recommendation';
                        
                        // Find intro paragraph
                        const introMatch = text.match(/# .*?\n(.*?)(?:\n\n|$)/);
                        const intro = introMatch ? introMatch[1] : '';
                        
                        // Format outfit ideas
                        let formattedContent = '<div class="recommendation-title">' + title + '</div>';
                        formattedContent += '<p class="recommendation-intro">' + intro + '</p>';
                        
                        // Clean up the text for better parsing
                        text = text.replace(/##/g, ''); // Remove ## markers
                        text = text.replace(/\*\*/g, ''); // Remove ** markers
                        
                        // Extract outfit sections using a more robust pattern
                        const outfitPattern = /Outfit Idea (\d+): ([^\n]+)([\s\S]*?)(?=Outfit Idea \d+:|Where to Shop|$)/g;
                        let match;
                        let outfitNumber = 1;
                        
                        while ((match = outfitPattern.exec(text)) !== null) {
                            const outfitTitle = match[2].trim();
                            let outfitDetails = match[3].trim();
                            
                            formattedContent += '<div class="outfit-section">';
                            formattedContent += '<div class="outfit-title">Outfit Idea ' + outfitNumber + ': ' + outfitTitle + '</div>';
                            
                            // Parse each item in the outfit
                            const itemPattern = /- (Top|Bottom|Outerwear|Shoes|Accessories): ([^-]+)/g;
                            let itemMatch;
                            
                            while ((itemMatch = itemPattern.exec(outfitDetails)) !== null) {
                                formattedContent += '<div class="outfit-item"><strong>' + itemMatch[1] + ':</strong> ' + itemMatch[2].trim() + '</div>';
                            }
                            
                            formattedContent += '</div>';
                            outfitNumber++;
                        }
                        
                        // Add Where to Shop section if it exists
                        const shopMatch = text.match(/Where to Shop([\s\S]*?)$/);
                        if (shopMatch) {
                            formattedContent += '<div class="where-to-shop">Where to Shop</div>';
                            formattedContent += '<p>' + shopMatch[1].trim() + '</p>';
                        }
                        
                        contentElement.innerHTML = formattedContent;
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>