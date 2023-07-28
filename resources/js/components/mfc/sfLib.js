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
    function readFile(v,callback){
        var file = v.files[0];
        var fileReader = new FileReader();

        new Promise(function(res){
            fileReader.onload = function(event) {
                var typedarray = new Uint8Array(event.target.result);
                return res({
                    size    :file.size,
                    nama    :file.name,
                    type    :"application/pdf",
                    data    :btoa(Uint8ToString(typedarray))
                })
            };
            fileReader.readAsArrayBuffer(file);
        }).then(resp=>{
            callback(resp);
        });

        // console.log(fileReader);
    }
    function Uint8ToString(u8a){
        var CHUNK_SZ = 0x8000;
        var c = [];
        for (var i=0; i < u8a.length; i+=CHUNK_SZ) {
          c.push(String.fromCharCode.apply(null, u8a.subarray(i, i+CHUNK_SZ)));
        }
        return c.join("");
    }
    return {
        coptionSelect,
        objToCB,
        _$,
        readFile,
    }
})();
export default sfLib;
