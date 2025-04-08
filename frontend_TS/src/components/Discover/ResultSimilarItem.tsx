import { SimilarItemsProps } from "../../models/PromptingModel";

/*
 * This component is used to display a list of similar items found from the API response.
 * 
 * @param param0 - The props for the SimilarItems component. (Located in the models/PromptingModel.ts)
 * @returns Results of similar items found from the API response in UI format.
 */
const SimilarItems = ({ items }: SimilarItemsProps) => {

    return (
      <div className="fai-results-section">

        <h4 className="fai-section-title">Similar Items Found</h4>

        {/* Loops through result of SimilarItem List to display all result. */}
        {items.map((item) => (
          <div className="fai-suggestion-item" key={item.id}>
            <img className="fai-suggestion-image" src={item.image} alt={item.name} />
            
            <div className="fai-suggestion-details">

              <div className="fai-suggestion-name">{item.name}</div>
              <div className="fai-suggestion-description">{item.description}</div>
              <div className="fai-suggestion-price">{item.price}</div>

              {/* Button with link to the shop URL*/}
              <a href={item.shopUrl} className="fai-suggestion-link" target="_blank" rel="noopener noreferrer">
                Shop Now
              </a>

            </div>
          </div>
        ))}


      </div>
    );
  };
  
  export default SimilarItems;