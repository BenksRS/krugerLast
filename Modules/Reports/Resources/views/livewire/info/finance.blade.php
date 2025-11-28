<div>
   <div class="row">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  @if($this->retorno)
                     Total jobs: {{$this->retorno['total']}} (Pending:{{$this->retorno['open']}} - Completed: {{$this->retorno['completed']}} - Closed: {{$this->retorno['closed']}})<br>
                     Jobs billed:{{$this->retorno['billing']}} Total Invoices amount: {{$this->retorno['total_billing']}} Average amount: {{$this->retorno['media_billing']}}<br>
                     Jobs billed Tree Removal:{{$this->retorno['total_tree_billing']}} <br>
                     Jobs paid: {{$this->retorno['paid']}} Total amount: {{$this->retorno['total_paid']}} Average amount: {{$this->retorno['media_paid']}}<br>
                     <hr>
                     Jobs Direct Bill: {{$this->retorno['direct_bill']['total']}} (Pending:{{$this->retorno['direct_bill']['open']}} - Completed: {{$this->retorno['direct_bill']['completed']}} - Closed: {{$this->retorno['direct_bill']['closed']}})
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>

</div>