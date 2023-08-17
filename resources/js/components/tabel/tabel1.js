/* eslint-disable react/prop-types */
import React from "react";
import DataTable from 'react-data-table-component';

function Tabel1({
        search = undefined,
        oncSearch,data,columns,
        fixedHeader= false, fixedHeaderScrollHeight ='300px' ,
        checkboxSelection = null,pagination = "true",
        cinput ='w30p',
        btnAction = undefined,
        ExpandedComponent = null,
        rowSelectCritera = false,
        selectData =()=>{}}){
    return (
        <>
            {
                ( btnAction!= undefined &&
                    btnAction
                )
            }
            {
                (
                    search!=undefined &&
                    <div className="justifyEnd">
                        <div className={`iconInput2 ${cinput}`}>
                            <input className="borderR10px" type="text" value={search} onChange={oncSearch}  placeholder="search..." />
                            <span className="mdi mdi-cloud-search "></span>
                        </div>
                    </div>
                )
            }
            <DataTable
                pagination={pagination}
                columns={columns}
                data={data}
                selectableRows={(checkboxSelection!= null && true)}
                fixedHeader={fixedHeader}
                fixedHeaderScrollHeight={fixedHeaderScrollHeight}
                expandableRows={(ExpandedComponent!= null && true)}
                expandableRowsComponent={ExpandedComponent == null ? (()=>{}): ExpandedComponent}
                onSelectedRowsChange={checkboxSelection == null ? (()=>{}): checkboxSelection }
                selectableRowSelected={rowSelectCritera}
                onRowClicked={selectData}
            />
        </>
    );
}
// Tabel1.propTypes = {
//     search : PropTypes.string.isRequired,
//     oncSearch : PropTypes.func.isRequired,
//     data : PropTypes.array.isRequired,
//     columns : PropTypes.array.isRequired,

//     // fixedHeader: PropTypes.bool.isRequired,
//     fixedHeaderScrollHeight: PropTypes.string.isRequired,
//     checkboxSelection: PropTypes.string.isRequired,
//     pagination : PropTypes.string.isRequired,

//     cinput : PropTypes.string.isRequired,
//     btnAction: PropTypes.string.isRequired,
//     ExpandedComponent: PropTypes.string.isRequired,
//     rowSelectCritera: PropTypes.bool.isRequired,

//     selectData: PropTypes.func.isRequired,
// }
export default Tabel1;
