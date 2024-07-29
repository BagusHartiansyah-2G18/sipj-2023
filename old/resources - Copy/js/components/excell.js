// var xlsx = require("xlsx");
// function Upload() {
//     function handleFile(e) {
//          e.preventDefault()
//          if (e.target.files) {
//          // read xlsx data
//          }

//     }

//     return(
//          <form>
//               <input type="file" onChange={handleFile}></input>
//          </form>
//     )

//     const reader = new FileReader()

//     reader.onload = (e) => {
//         const data = e.target.result
//         const workbook = xlsx.read(data, {type: "array})
//         // organize xlsx data into desired format

//     }
//     try {
//         reader.readAsArrayBuffer(e.target.files[0])
//         workbook.SheetNames.forEach((sheet)=>{
//             const worksheet = workbook.Sheets[sheet]
//             // format object
//        })
//     } catch (error) {
//         worksheet.B1.v
//         worksheet['B1']['v']
//         for (let row = 1; row < lastRow ; row++) {
//             for (let column = 'A'; column < lastColumn; column++) {
//                  cellValue = worksheet[`${column}${row}`]['v']
//                  // do something with cell value
//             }
//        }
//        function nextChar(letter) {
//             return String.fromCharCode(letter.charCodeAt(0) + 1);
//         }
//     }

//     function maxCell(cell1, cell2) {
//         var row1 = cell1.slice(1)
//         var column1 = parseInt(cell1.slice(0,1))
//         var row2 = cell2.slice(1)
//         var column2 = parseInt(cell2.slice(0,1))
    
//         var maxColumn = (column1 > column2) ? column1 : column 2
//         var maxRow = (row1 > row2) ? row1.toString() : row2.toString()
    
//         return `${maxColumn}${maxRow}`
//     }
//     function nextChar(letter) {
//         return String.fromCharCode(letter.charCodeAt(0) + 1);
//     }
//     const largestCell = 'E8'
//     const lastRow = largestCell.slice(1)
//     const lastColumn = largestCell.slice(0,1)
//     function maxArray(array) {
//         var max = ''
//         array.forEach((elem)=>{
//             max = maxCell(max, elem)
//         })
//         return max
//     }
//     function maxCell(cell1, cell2) {
//         if (cell1 > cell2) {
//             return cell1
//         } else {
//             return cell2
//         } 
//     }
// }
