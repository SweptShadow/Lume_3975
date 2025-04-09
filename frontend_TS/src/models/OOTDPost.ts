
//! Follow attribute naming from Licma
// export interface OOTDPost
// {
//     postId: number;
//     title: string;
//     imageUrl: string;
//     description?: string;
//     createdAt: string;
//     username: string;
// }

/**
 * Match backend/app/models Article.php 
 */
export interface OOTDPost
{
    id: number;
    title: string;
    content: string;
    likes: number;
}