import { useEffect, useState } from "react";
import { OOTDPost } from "../models/OOTDPost";
import { OOTDService } from "../services/OOTDService";

const OOTDPostList = () => {
    const [posts, setPosts] = useState<OOTDPost[]>([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        const fetchPosts = async () => {
            const fetchedPosts = await OOTDService.getAllPosts();
            setPosts(fetchedPosts);
            setLoading(false);
        };
        fetchPosts();
    }, []);

    if (loading) {
        return <div>Loading...</div>;
    }

    return (
        <div className="ootd-post-list">
            {posts.map((post) => (
                <div key={post.postId} className="ootd-post-card">
                    <img src={ post.imageUrl } alt={ post.title } className="ootd-post-image" />
                    {/* Do we need title? */}
                    <h3>{post.title}</h3>
                    <p>{ post.description }</p>
                    {/* Like and Comment button */}
                    <small>Posted by {post.username} on {new Date(post.createdAt).toLocaleDateString()}</small>
                </div>
            ))}
        </div>
    );
};

export default OOTDPostList;