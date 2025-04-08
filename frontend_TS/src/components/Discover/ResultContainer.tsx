import SimilarItems from './ResultSimilarItem';
import StyleAnalysis from './ResultStyleAnalysis';
import LoadingSpinner from './ImgLoading';
import { ResultsContainerProps } from '../../models/PromptingModel';
import { AIResponse, SimilarItemsResult, StyleAnalysis as StyleAnalysisType } from '../../models/ApiResponseModel';

/*
 * This component is used to display the results of the AI fashion analysis. (Including similar items and style analysis)
 * 
 * @param param0 - The props for the ResultsContainer component. (Located in the models/PromptingModel.ts)
 * @returns Results of AI fashion analysis in UI format.
 */
const ResultsContainer = ({ isLoading, results }: ResultsContainerProps) => {

    //To check if the result is of type SimilarItemsResult
    const isSimilarItemsResult = (result: AIResponse): result is SimilarItemsResult => {
      return 'items' in result;                                  
    };
    

    return (

        /* if there is response from API, then display */
      <div className="fai-results-container" style={{ display: results || isLoading ? 'block' : 'none' }}>
        
        <div className="fai-results-header">
          <h3 className="fai-results-title">Fashion Suggestions</h3>
        </div>
        
        {/* Conditional rendering based on loading state. If loading, display LoadingSpinner. Else, result container.*/}
        {isLoading ? (
          <LoadingSpinner />

        ) : (

          <div className="fai-results-content">

            {/* If no results are available, show an empty state message */}
            {!results ? (
              <div className="fai-empty-state">
                <p>Upload an image to see AI-powered fashion recommendations</p>
              </div>


            ) : isSimilarItemsResult(results) ? (
              //If the result is of type SimilarItemsResult, display similar items.
              <SimilarItems items={results.items} />
            ) : (


              //Otherwise, display the style analysis result.
              <StyleAnalysis analysis={results as StyleAnalysisType} />
            )}
          </div>
        )}

        
      </div>
    );
  };
  
  export default ResultsContainer;