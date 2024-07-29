/* eslint-disable react/prop-types */
import React from "react";
import Modal from 'react-modal';
import { useSelector } from 'react-redux';
import PropTypes from 'prop-types';

function Modal1 ({ children, cls='mw600px mtop100px' }){
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

Modal1.propTypes ={
    children : PropTypes.any.isRequired,
    // cls : PropTypes.string.isRequired
}
export default Modal1;
