import { StyleAnalysisProps } from "../../models/PromptingModel";


/*
 * This component is used to display the style analysis results, including styling recommendations and alternative styles.
 *
 * @param param0 - The props for the StyleAnalysis component. (Located in the models/PromptingModel.ts)
 * @returns Results of style analysis items found from the API response in UI format.
 */
const StyleAnalysis = ({ analysis }: StyleAnalysisProps) => {
  return (

    <>{/* DON'T DELETE THIS TAG!!!! This is a fragment that contains the style analysis results */}

      <div className="fai-results-section">
        <h4 className="fai-section-title">Outfit Style Analysis</h4>
        <p>{analysis.description}</p>
      </div>


      <div className="fai-results-section">
        <h4 className="fai-section-title">Styling Recommendations</h4>
        <ul style={{ paddingLeft: "20px", marginBottom: "var(--spacing-md)" }}>

          {analysis.recommendations.map((recommendation, index) => (
            <li key={index}>{recommendation}</li>
          ))}

        </ul>
      </div>


      <div className="fai-results-section">
        <h4 className="fai-section-title">Alternative Style Directions</h4>

        {analysis.alternativeStyles.map((style) => (
          <div className="fai-suggestion-item" key={style.id}>
            <img
              className="fai-suggestion-image"
              src={style.image}
              alt={style.name}
            />
            <div className="fai-suggestion-details">
              <div className="fai-suggestion-name">{style.name}</div>
              <div className="fai-suggestion-description">
                {style.description}
              </div>
            </div>
          </div>
        ))}

      </div>

    </> 
  );
};

export default StyleAnalysis;
