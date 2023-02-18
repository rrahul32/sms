
<div id="container">

</div>

<script>
    document.title="Payments"; 
    document.querySelector('h3').innerText="Select Student";
    //confirmation function
    function confirmation(){
        const value=document.getElementById('amount').value;
        if(isNaN(value))
        {
          document.getElementById('formAlert').innerHTML=`
      <div class="alert alert-danger alert-dismissible" role="alert">
  <div>Please enter a valid amount!</div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
      `;
          return false;
        }
        else 
        return confirm(`Confirm payment of Rs. ${document.getElementById('amount').value}?`);
      }      

      //set Print
      function setPrint(rdata){
        console.log(rdata);
        const form= document.createElement('form');
        form.setAttribute('method','POST');
        form.setAttribute('action','print.php')
        form.setAttribute('id','printForm')
        form.innerHTML=`
        <input type='text' name='data' value='${rdata}'>
        <input type='submit' value='submit'>
        `;
        document.body.appendChild(form);
        document.querySelector('#printForm').submit();

      }


      //displaying student details
    function getDetails(student, payment){
      // console.log(student);
      // console.log(payment);
      const target=document.getElementById('container');
      target.setAttribute('class', 'container mx-auto p-5 border justify-content-center bg-light overflow-auto');
      target.setAttribute('style','background-color:darkgray');
      const row1= document.createElement('div');
      row1.setAttribute('class','row g-4 border my-auto pb-3');
      const heading=document.createElement('h2');
      heading.setAttribute('class',"d-flex text-center justify-content-center mb-0");
      heading.innerText='Student Details';
      row1.appendChild(heading);
      // console.log(Object.entries(student));
      Object.entries(student).forEach((ele)=>{
        const col= document.createElement('div');
      col.setAttribute('class', 'col-auto mx-auto');
      const tag= document.createElement('span');
      tag.innerText=`${capitalise(ele[0])}: `;
      const value=document.createElement('span');
      value.setAttribute('class','border bg-white p-1')
      value.innerText=capitalise(ele[1]);
      tag.appendChild(value);
      col.appendChild(tag);
      row1.appendChild(col);
      });
      target.appendChild(row1);
      //payment
      row3=document.createElement('div');
      row3.setAttribute('class', 'row g-4 border my-auto pb-3');
      const heading3=document.createElement('h2');
      heading3.setAttribute('class',"d-flex text-center justify-content-center mb-0")
      heading3.innerText='Payment';
      row3.appendChild(heading3);
      const form=document.createElement('form');
      form.setAttribute('method','post');
      // form.setAttribute('target','pay.php');
      const amt=document.createElement('input');
      amt.setAttribute('type','text')
      amt.setAttribute('name','amount');
      amt.setAttribute('id','amount')
      amt.setAttribute('required',true);
      const id=document.createElement('input');
      id.setAttribute('type','hidden');
      id.setAttribute('name','admno');
      id.setAttribute('value',`${student.admno}`)
      form.appendChild(id);
      const formrow1=document.createElement('div');
      formrow1.setAttribute('class','row justify-content-center')
      const fr1c1=document.createElement('div');
      fr1c1.setAttribute('class','d-flex col-6');
      const fr1c1c1= document.createElement('div');
      fr1c1c1.setAttribute('class','col p-1');
      fr1c1c1.appendChild(amt);
      fr1c1.appendChild(fr1c1c1);
      const fr1c1c2=document.createElement('div');
      fr1c1c2.setAttribute('class','col-auto justify-content-center');
      const pay=document.createElement('button');
      pay.setAttribute('type','submit')
      pay.setAttribute('name','pay');
      pay.setAttribute('class','mx-auto btn btn-primary');
      pay.innerText='Pay';
      fr1c1c2.appendChild(pay);
      fr1c1.appendChild(fr1c1c2)
      formrow1.appendChild(fr1c1);
      form.appendChild(formrow1);
      const formalert=document.createElement('div');
      formalert.setAttribute('id','formAlert');
      form.appendChild(formalert);
      form.setAttribute('onsubmit','return confirmation();')
      // form.addEventListener('submit',()=>{
      //   return confirm(`Confirm payment of Rs. ${amt.value}?`);
      // });
      row3.appendChild(form);
      target.appendChild(row3);
      // onsubmit="return confirm('Are you sure you want to submit this form?');

      //payment history
     if(payment.length!=0)
      {
      row2=document.createElement('div');
      row2.setAttribute('class', 'row g-4 border my-auto pb-3');
      const heading2=document.createElement('h2');
      heading2.setAttribute('class',"d-flex text-center justify-content-center mb-0")
      heading2.innerText='Payment History';
      row2.appendChild(heading2);
      const table=document.createElement('table');
      table.setAttribute('class','table table-bordered');
      const thead=document.createElement('thead');
      const trow=document.createElement('tr');
      const sno=document.createElement('th');
      sno.setAttribute('scope','column');
      sno.innerText='S.No.';
      let no=1;
      const amount=document.createElement('th');
      amount.setAttribute('scope','column');
      amount.innerText='Amount';
      const date=document.createElement('th');
      date.setAttribute('scope','column');
      date.innerText='Date';
      const invoice=document.createElement('th');
      invoice.setAttribute('scope','column');
      invoice.innerText='Receipt';
      trow.append(sno,amount,date,invoice);
      thead.appendChild(trow);
      table.appendChild(thead);
      const tbody=document.createElement('tbody');


      payment.forEach((ele)=>{
        const tr=document.createElement('tr');
        const sndata= document.createElement('td');
        sndata.innerText=no++;
        tr.appendChild(sndata);
        //console.log(ele);
        for(i=2;i<=3;i++){
        td=document.createElement('td');
        td.innerText=ele[i];
        tr.appendChild(td);
        }
        const receipt=document.createElement('td');
        receipt.innerHTML=`<button class='btn btn-primary' onclick='setPrint(${JSON.stringify(ele)})'>Print</button>`;
        tr.appendChild(receipt);
        tbody.appendChild(tr);
      })


      table.appendChild(tbody);
      row2.appendChild(table);
      target.appendChild(row2);
    }
    }
    if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}

    //post success
    function invoice(data){
      //create Modal
      const newDiv=document.createElement('div');
      newDiv.innerHTML=`
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Receipt</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="printText" style="width:14.8cm;height:21cm" >
      hello
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
      </div>
    </div>
  </div>
</div>
      `;
      document.body.append(newDiv);

  const modal= new bootstrap.Modal(document.getElementById('staticBackdrop'));
  modal.show();
}
   </script>
