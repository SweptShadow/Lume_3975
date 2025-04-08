/*
 * This component displays a loading spinner while the image is being processed to Ai.
 * 
 * @returns LoadingSpinner component.
 */
const LoadingSpinner = () => {
  return (
    <div className="fai-loading">
      <div className="fai-spinner"></div>
      <p>Analyzing your image...</p>
    </div>
  );
};

export default LoadingSpinner;
