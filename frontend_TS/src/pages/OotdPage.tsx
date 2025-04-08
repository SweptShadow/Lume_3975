

/**
 * Renders the OOTD (Outfit of the Day) page layout.
 * Right now uses a mock image and buttons for like and comment.
 * @returns 
 */
const OotdPage = () =>
{
    return (
        <div className="ootd-container">
            {/* LEFT COLUMN */ }
            <div className="ootd-column justify-content-center">
                <h1 className="ootd-title text-center w-100">OOTD</h1>
                <div className="post-column">

                    {/* OOTD Post Card */ }
                    <div className="card mb-4 mx-auto" style={ { maxWidth: '400px' } }>
                        {/* Image */ }
                        <img
                            src="/images/mockimage.jpeg"
                            className="card-img-top img-fluid"
                            alt="OOTD"
                        />
                        {/* Buttons */ }
                        <div className="card-body d-flex justify-content-around">
                            <button type="button" className="btn btn-outline-dark">
                                ❤️ Like
                            </button>
                            <button type="button" className="btn btn-outline-dark">
                                💬 Comment
                            </button>
                        </div>
                        {/* Card End */ }
                    </div>
                </div>
            </div>
        </div>
    );
};

export default OotdPage;

// import OOTDPostList from "../components/OOTDPostList";

// const OotdPage = () =>
// {
//     return (
//         <div className="ootd-container">
//             <h1 className="ootd-title text-center">OOTD</h1>
//             <OOTDPostList />
//         </div>
//     );
// };

// export default OotdPage;

// Backend needss Route::get('/ootd', [OOTDController::class, 'index']);
