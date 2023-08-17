/* eslint-disable react/no-deprecated */
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

// require('./bootstrap');

// /**
//  * Next, we will create a fresh React component instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
// require('./components/HelloReact');
// require('./Counter');

import React, { useEffect }  from 'react';
import { useDispatch, useSelector } from 'react-redux';

import ReactDOM from 'react-dom';
import { BrowserRouter, Routes, Route } from "react-router-dom";
import { Provider } from 'react-redux';

import Dashboard from "./pages/Dashboard";
import Navbar from "./components/dashboard/Navbar";
import HeaderM from "./components/dashboard/Header1";
import Footer1 from "./components/dashboard/Footer1";

import Dinas from './pages/Dinas';
import Subkegiatan from './pages/Subkegiatan';
import RekeningBelanja from './pages/RekeningBelanja';
import JenisPertanggungJawab from './pages/JenisPertanggungJawab';

import BidangSubKegiatan from './pages/BidangSubKegiatan';
import BidangEntriBelanja from './pages/BidangEntriBelanja';
import SPPD from './pages/work/sppd';
import Fitur from './pages/Fitur';

import { setAll, session, changeMenu} from "./states/sfHtml/action";
import { ToastContainer } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';


import store from './states';
function MyApp() {
    const { _html } = useSelector((state) => state);
    const dispatch = useDispatch();
    useEffect(() => {
        dispatch(setAll({
            leftBar : 0,
            // indMenu : ind,
            // menuSub : 'dashboard',
            url     : window.location.origin
        }));
        dispatch(session());
        dispatch(changeMenu(window.location.pathname));
    }, [dispatch]);

    if(_html.sess === undefined ){
        return <></>;
    }
    const sess = _html.sess;
    return (
        <>
            <HeaderM></HeaderM>
            <main className="flexR blight">
                <Navbar />
                <div className='pwrap w100p'>
                    <div className='w95p m0auto mxh100p pbottom100px'>
                        <Routes>
                            {
                                (
                                    _html.indMenu === 0  &&
                                    (
                                        <>
                                            <Route path="/home/dashboard" element={<Dashboard /> } />
                                            {
                                                ( sess.kdJaba !== '1' &&
                                                    <>
                                                        <Route path="/home/dinas" element={<Dinas /> } />
                                                        <Route path="/home/rekeningBelanja" element={<RekeningBelanja /> } />
                                                        <Route path="/home/jenisP" element={<JenisPertanggungJawab /> } />
                                                    </>
                                                )
                                            }
                                            <Route path="/home/subkegiatan" element={<Subkegiatan /> } />
                                            <Route path="*" element={<Dashboard /> } />
                                        </>
                                    )
                                )
                            }{
                                (
                                    _html.indMenu === 1  &&
                                    (
                                        <>
                                            <Route path="home/work/subBidang" element={<BidangSubKegiatan /> } />
                                            <Route path="home/work/rincianBelanja" element={<BidangEntriBelanja /> } />
                                            <Route path="home/work/Fitur" element={<Fitur /> } />
                                            <Route path="home/work/sppd/:value" element={<SPPD /> } />
                                            {/* <Route path="home/work/Fitur" element={<Fitur /> } /> */}
                                        </>
                                    )
                                )
                            }

                        </Routes>
                    </div>
                    <ToastContainer></ToastContainer>
                    {/* <Footer1
                        text='Bappeda @2024'
                    ></Footer1> */}
                </div>
            </main>
        </>
    );
}

export default MyApp;

if (document.getElementById('app')) {
    ReactDOM.render(
        <Provider store={store}>
            <BrowserRouter>
                <MyApp />
            </BrowserRouter>
        </Provider>
        , document.getElementById('app'));
}
