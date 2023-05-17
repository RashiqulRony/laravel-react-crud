
import http from "../http"
import {useState, useEffect} from "react";
import {Link} from "react-router-dom";
export default function posts() {
    // eslint-disable-next-line react-hooks/rules-of-hooks
    const [posts, setPosts] = useState([]);

    // eslint-disable-next-line react-hooks/rules-of-hooks
    useEffect(() => {
        getPosts();
    }, []);

    const getPosts = () => {
        http.get('/posts').then((response) => response.data)
            .then((response) => {
                if (response.status === true) {
                    setPosts(response.data)
                }
            }).catch((error) => {
            console.log(error);
        });

    }
    return (
        <div>
            <div className="card mt-5">
                <div className="card-header">
                    Posts
                    <Link className="btn btn-sm btn-success float-end" to={'/posts/create'}>Add New</Link>
                </div>

                <div className="card-body">
                    <div className="table-responsive">
                        <table className="table table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {posts.map((post, index) => (
                                <tr key={index}>
                                    <td>{post.id}</td>
                                    <td>Img</td>
                                    <td>{post.title}</td>
                                    <td>{post.description}</td>
                                    <td>{post.status}</td>
                                    <td>
                                        <button className="btn btn-sm btn-info m-1">Edit</button>
                                        <button className="btn btn-sm btn-danger m-1">Delete</button>
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    )
}