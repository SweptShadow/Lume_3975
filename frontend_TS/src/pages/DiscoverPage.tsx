import FashionAnalyzer from '../components/Discover/Prompt';

/**
 * This is the complete DiscoverPage with all components combined together.
 * 
 * @returns DiscoverPage component that serves as the main entry point for the fashion analysis feature.
 */
const DiscoverPage = () => {
  return (
    <div className="fai-container">
      <FashionAnalyzer />
    </div>
  );
};

export default DiscoverPage;