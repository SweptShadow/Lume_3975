import { Link } from "react-router-dom";

const Navbar = () =>
{
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
                            <Link className="nav-link" to="/shop">Register</Link>
                        </li>
                        <li className="nav-item">
                            <Link className="nav-link" to="/about">Login</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
