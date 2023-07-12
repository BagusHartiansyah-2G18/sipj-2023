import React from "react";
import Modal from 'react-modal';
import { useDispatch, useSelector } from 'react-redux';

function Modal1 ({children, cls='mw600px mtop100px'}){
    const { _html } = useSelector((state) => state); 
    return (
        <Modal id='dialog1'
            className={`modal1 ${cls} m0auto`}
            isOpen={_html.modal} 
            contentLabel="Modal"
            ariaHideApp={false}
        >
            {children}
        </Modal>
    );
}
export default Modal1;