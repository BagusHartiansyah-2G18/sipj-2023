const sfLib =(()=>{

    function coptionSelect({dt,row,xind=false}){
        let xdt=[];
        dt.forEach((val,ind) => {
           xdt.push({
                value:(xind?ind:val[row.value]),
                label:val[row.label]
           }) 
        });
        return xdt;
    }
    function objToCB({dt,label,value}){
        let xdt=[];
        label.forEach((val,ind) => {
            xdt.push({
                    value:dt[value[ind]],
                    label:dt[val]
            }) 
        });
        return xdt;
    }
    function _$(val){
        const uang = new Intl.NumberFormat('en-US',
            { 
                style: 'currency', 
                currency: 'USD',
                minimumFractionDigits: 3 
            }
        );
        var tam="";
        if(val==null || val=='null'){
            return '';
        }
        if(uang.format(val).substring(0,1)=="$"){ 
            tam=uang.format(val).substring(1);
        }else{
            tam=uang.format(val);
        }
        return tam.substring(0,tam.length-4);
    }
    return {
        coptionSelect,
        objToCB,
        _$,
    }
})();
export default sfLib;