import { Link } from 'react-router-dom';

const LandingPage = () =>
{
    return (
        <div className="landing-page-container">
            {/* LEFT COLUMN */ }
            <div className="landing-page-left-column">
                <h1 className="landing-title text-center w-100">lumé</h1>
                <div className="button-row">
                    <Link to="/discover" className="btn btn-dark">DISCOVER</Link>
                    <Link to="/ootd" className="btn btn-dark">OOTD</Link>
                </div>
            </div>

            {/* RIGHT COLUMN */ }
            <div className="landing-page-right-column">
                <img
                    src="/images/landing1.jpeg"
                    alt="Placeholder"
                    className="right-column-image"
                />
            </div>
        </div>
    );
};

export default LandingPage;