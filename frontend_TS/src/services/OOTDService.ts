import { OOTDPost } from "../models/OOTDPost";
import { API_BASE_URL } from "../config/index";

export const OOTDService = {
    /**
     * Fetches all OOTD posts from the backend.
     * 
     * @returns A list of OOTD posts.
     */
    getAllPosts: async (): Promise<OOTDPost[]> =>
    {
        try
        {
            // Calls: http://127.0.0.1:8000/api/articles
            const response = await fetch(`${ API_BASE_URL }/articles`);
            if (!response.ok)
            {
                throw new Error(`(OOTDService.ts)Failed to fetch OOTD posts: ${ response.status }`);
            }
            return await response.json();
        }
        catch (error)
        {
            console.error("(OOTDService.ts)Error fetching OOTD posts:", error);
            return [];
        }
    },

    // This method fetches posts by ID
    async getPostById (id: number): Promise<OOTDPost | null>
    {
        const posts = await this.getAllPosts();
        return posts.find((post) => post.id === id) || null;
    }
};

