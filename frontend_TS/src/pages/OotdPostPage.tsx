import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import { OOTDService } from "../services/OOTDService";
import { OOTDPost } from "../models/OOTDPost";

/**
 * This renders for an individual post
 */
const OOTDPostPage = () =>
{
    const { id } = useParams();
    const [ post, setPost ] = useState<OOTDPost | null>(null);
    const [ loading, setLoading ] = useState(true);

    useEffect(() =>
    {
        const fetchPost = async () =>
        {
            if (id)
            {
                const result = await OOTDService.getPostById(Number(id));
                setPost(result);
            }
            setLoading(false);
        };
        fetchPost();
    }, [ id ]);

    if (loading) return <div>Loading...</div>;
    if (!post) return <div>Post not found.</div>;

    return (
        <div className="ootd-post-page">
            <h2>{ post.title }</h2>
            <img src="/images/mockimage.jpeg" alt="OOTD" className="img-fluid" />
            <p>{ post.content }</p>
        </div>
    );
};

export default OOTDPostPage;
