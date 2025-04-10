import { Link } from "react-router-dom";
import { API_BASE_URL } from "../config/index";

const Navbar = () => {
    return (
        <nav className="navbar navbar-expand-lg bg-white shadow-sm px-4">
            <div className="container-fluid">
                {/* Lume Logo */ }
                <Link className="navbar-brand fw-bold fs-3" to="/">
                    lumé
                </Link>

                {/* links */ }
                <div className="ms-auto">
                    <ul className="navbar-nav d-flex flex-row gap-4">
                        <li className="nav-item">
                            <a className="nav-link" href={`${API_BASE_URL}/index.php/signup`}>Register</a>
                        </li>
                        <li className="nav-item">
                            <a className="nav-link" href={`${API_BASE_URL}/index.php/login`}>Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
