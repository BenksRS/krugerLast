<div>
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  @if($this->retorno)
                     <p><b>Total Jobs:</b> {{$this->retorno['total']}} (Pending: {{$this->retorno['open']}} - Completed: {{$this->retorno['completed']}} - Closed: {{$this->retorno['closed']}})</p><br>
                     <p><b>Total Jobs Direct Bill:</b> {{$this->retorno['direct_bill']['total']}} (Pending: {{$this->retorno['direct_bill']['open']}} - Completed: {{$this->retorno['direct_bill']['completed']}} - Closed: {{$this->retorno['direct_bill']['closed']}})</p><br>
                     <p><b>Jobs Billed:</b> {{$this->retorno['billing']}} - Total Invoices amount: {{$this->retorno['total_billing']}} - Average amount: {{$this->retorno['media_billing']}}</p><br>
                     <p><b>Jobs Billed Tree Removal:</b> {{$this->retorno['total_tree_billing']}}</p><br>
                     <p><b>Jobs Paid:</b> {{$this->retorno['paid']}} - Total amount: {{$this->retorno['total_paid']}} - Average amount: {{$this->retorno['media_paid']}}</p><br>

                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

</div>