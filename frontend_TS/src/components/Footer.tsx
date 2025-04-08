import { Link } from "react-router-dom";

const Footer = () =>
{
    return (
        <footer className="footer bg-white shadow-sm mt-auto">
            <div className="container-fluid py-4">
                <div className="row text-center">
                    <div className="col">
                        <p className="mb-0">© 2023 lumé. All rights reserved.</p>
                    </div>
                </div>
                <div className="row text-center mt-2">
                    <div className="col">
                        <Link to="#" className="text-decoration-none">Privacy Policy</Link> |
                        <Link to="#" className="text-decoration-none"> Terms of Service</Link>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
