import React, {useRef} from 'react';

function FilesUpload ({ onFileSelectSuccess, onFileSelectError }) {
    const fileInput = useRef(null)

    const handleFileInput = (e) => {
        // handle validations
        const file = e.target.files[0];
        if (file.size > 10240000)
            onFileSelectError({ error: "File size cannot exceed more than 10MB" });
        else onFileSelectSuccess(file);
    }

    return (
        <div className="file-uploader">
            <input type="file" onChange={handleFileInput}/>
            <button onClick={e => fileInput.current && fileInput.current.click()} className="btn btn-primary"></button>
        </div>
    )
}
export default FilesUpload;
