import { OOTDPost } from "../models/OOTDPost";
import Config from "../config/index";

export const OOTDService = {
    /**
     * Fetch all OOTD posts from the backend.
     * 
     * @returns A list of OOTD posts.
     */
    getAllPosts: async (): Promise<OOTDPost[]> =>
    {
        try
        {
            const response = await fetch(`${ Config.API_BASE_URL }/ootd`);
            if (!response.ok)
            {
                throw new Error(`Failed to fetch OOTD posts: ${ response.status }`);
            }
            return await response.json();
        } catch (error)
        {
            console.error("Error fetching OOTD posts:", error);
            return [];
        }
    }
};