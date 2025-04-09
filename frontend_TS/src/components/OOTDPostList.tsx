import { useEffect, useState } from "react";
import { OOTDPost } from "../models/OOTDPost";
import { OOTDService } from "../services/OOTDService";
import { Link } from "react-router-dom"; 


/**
 * Displays the list of Posts from the backend
 */
const OOTDPostList = () =>
{
    const [ posts, setPosts ] = useState<OOTDPost[]>([]);
    const [ loading, setLoading ] = useState(true);
    const [ likes, setLikes ] = useState<{ [ id: number ]: number }>({});
    const [ liked, setLiked ] = useState<{ [ id: number ]: boolean }>({});

    // Handling Likes: Currently not fetching likes properly. 
    const handleLike = (postId: number) =>
    {
        setLikes((prevLikes) => ({
            ...prevLikes,
            [ postId ]: liked[ postId ] ? prevLikes[ postId ] - 1 : (prevLikes[ postId ] || 0) + 1,
        }));

        setLiked((prevLiked) => ({
            ...prevLiked,
            [ postId ]: !prevLiked[ postId ],
        }));
    };

    useEffect(() =>
    {
        const fetchPosts = async () =>
        {
            const fetchedPosts = await OOTDService.getAllPosts();
            setPosts(fetchedPosts);

            const initialLikes = fetchedPosts.reduce((acc, post) =>
            {
                acc[ post.id ] = 0;
                return acc;
            }, {} as { [ id: number ]: number });

            const initialLiked = fetchedPosts.reduce((acc, post) =>
            {
                acc[ post.id ] = false;
                return acc;
            }, {} as { [ id: number ]: boolean });

            setLikes(initialLikes);
            setLiked(initialLiked);
            setLoading(false);
        };
        fetchPosts();
    }, []);

    // Loading state
    if (loading)
    {
        return <div>Loading...</div>;
    }

    return (
        <div className="ootd-post-list">
            { posts.map((post) => (
                <div key={ post.id } className="ootd-post-card">

                    {/* Clickable title and image START */ }
                    <Link to={ `/ootd/${ post.id }` } style={ { textDecoration: "none", color: "inherit" } }>
                        <h3>{ post.title }</h3>
                        <img
                                src={OOTDService.getImageUrl(post.img)}
                                className="card-img-top img-fluid"
                                alt={post.title}
                                onError={(e) => {
                                    // Fallback if image fails to load
                                    const target = e.target as HTMLImageElement;
                                    target.src = "/images/image-placeholder.jpg";
                                    target.alt = "Image not available";
                                }}
                            />
                    </Link>
                    {/* Clickable title and image END */ }

                    {/* Buttons START*/}
                    <div className="card-body d-flex justify-content-around">
                        <button
                            type="button"
                            className={ `btn ${ liked[ post.id ] ? 'btn-dark' : 'btn-outline-dark' }` }
                            onClick={ () => handleLike(post.id) }
                        >
                            { liked[ post.id ] ? '❤️' : '❤️' } { likes[ post.id ] } Likes
                        </button>
                        <button type="button" className="btn btn-outline-dark">
                            💬 Comment
                        </button>
                    </div>
                    {/* Buttons END*/ }

                </div>
            )) }
        </div>
    );
};

export default OOTDPostList;
