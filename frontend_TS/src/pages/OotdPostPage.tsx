import { useParams } from "react-router-dom";
import { useEffect, useState } from "react";
import { OOTDService } from "../services/OOTDService";
import { OOTDPost } from "../models/OOTDPost";

/**
 * This renders an individual post by id.
 * e.g. /ootd/1, /ootd/2
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
            {/* Currently using a mock image */ }
            <img src="" alt="OOTD" className="img-fluid" />
            {/* { post.img } This should be  */ }
            <div className="ootd-container">
                <div className="ootd-column justify-content-center">
                    <div className="post-column" >
                        <div className="indie-card mb-4 mx-auto" style={ { maxWidth: '500px' } }>
                            <h1 className="ootd-indie-title text-center w-100">{ post.title }</h1>
                            
                            <img
                                src={ `http://localhost:8000/${ post.img }` }
                                alt={ post.title }
                                className="ootd-indie-img img-fluid mb-1"
                            />

                            <p className="ootd-indie-description">{ post.description }</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default OOTDPostPage;

