// import FashionAnalyzer from '../components/Discover/Prompt';
import AIRecommendationPanel from '../components/Discover/AIRecommendationPanel';

/**
 * This is the complete DiscoverPage with all components combined together.
 * 
 * @returns DiscoverPage component that serves as the main entry point for the fashion analysis feature.
 */
const DiscoverPage = () => {
  return (
    <div className="fai-container">
      <div className="page-title-container">
        <h1 className="page-title">Discover Your Style</h1>
      </div>
      
      {/* Add the AI Recommendation Panel */}
      <AIRecommendationPanel />
      
      {/* Original Fashion Analysis Component - future implementation with HM */}
      {/* <FashionAnalyzer /> */}
    </div>
  );
};

export default DiscoverPage;