import OOTDPostList from "../components/OOTDPostList";

/**
 * Renders the OOTD (Outfit of the Day) page layout.
 * Right now uses a mock image and buttons for like and comment.
 * @returns 
 */
const OotdPage = () =>
{
    return (
        <div className="ootd-container">
            <div className="ootd-column justify-content-center">
                <h1 className="ootd-title text-center w-100">OOTD</h1>
                <div className="post-column">
                    {/* OOTD Post Card */ }
                    <div className="card mb-4 mx-auto" style={ { maxWidth: '400px', border: "solid 2px red" } }>
                        <OOTDPostList />
                    </div>
                </div>
            </div>
        </div>
    );
};

export default OotdPage;


