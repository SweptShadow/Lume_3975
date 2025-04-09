/**
 * Match backend/app/models Article.php 
 */
export interface OOTDPost
{
    id: number;
    title: string;
    img: string; // Is this supposed to be a string? 
    description: string;
    likes: number;
}