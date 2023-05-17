
import http from "../http"
import {Link} from "react-router-dom";
export default function postCreate() {

    return (
        <div>
            <div className="card mt-5">
                <div className="card-header">
                    Post Create
                    <Link className="btn btn-sm btn-success float-end" to={'/posts'}>Back</Link>
                </div>

                <div className="card-body">
                    <form>
                        <div className="mb-3">
                            <label htmlFor="title" className="form-label">Title</label>
                            <input type="text" name="title" className="form-control" id="title" placeholder="Enter Title"/>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="description" className="form-label">Post Description</label>
                            <textarea className="form-control" name="description"  id="description" rows="3"></textarea>
                        </div>
                        <div className="mb-3">
                            <label htmlFor="image" className="form-label">Image</label>
                            <input type="file" className="form-control" name="image" id="image" accept="image/*" />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="status" className="form-label">Status</label>
                            <select className="form-control" name="status" id="status">
                                <option value="" hidden disabled selected>Select Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div className="mb-3">
                            <button type="submit" className="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    )
}