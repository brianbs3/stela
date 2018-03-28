<?php
require_once('Stela.php');
class Customers extends Stela {
  public function index()
  {
    $this->load->model('customers_model');
    $c = $this->customers_model->get_customers();
    $this->dump_array($c);
    echo"customers";
  }

  public function customerList()
  {
    echo"<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal' data-whatever='add'>Add Customer</button>";
    echo"
    <div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title' id='exampleModalLabel'>New message</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <form>
              <div class='form-group'>
                <label for='firstName' class='col-form-label'>First Name</label>
                <input type='text' class='form-control' id='firstName'>
              </div>
              <div class='form-group'>
                <label for='message-text' class='col-form-label'>Message:</label>
                <textarea class='form-control' id='message-text'></textarea>
              </div>
            </form>
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            <button type='button' class='btn btn-primary'>Send message</button>
          </div>
        </div>
      </div>
    </div>
    ";
    $this->load->model('customers_model');
    $customers = $this->customers_model->get_customers();
    echo"
      <h1 class=customersHeader>Customers</h1>
      <table class='table table-striped'>
        <thead class='thead-dark'>
          <tr>
            <th scope='col'>#</th>
            <th scope='col'>First</th>
            <th scope='col'>Last</th>
            <th scope='col'>Email</th>
            <th scope='col'>Address 1</th>
            <th scope='col'>Address 2</th>
            <th scope='col'>City</th>
            <th scope='col'>State</th>
            <th scope='col'>Zip</th>
            <th scope='col'>Phone</th>
            <th scope='col'>Email Promotion</th>
            <th scope='col'>Text Promotion</th>
            <th scope='col'>Appointment Reminder</th>
          </tr>
        </thead>
      <tbody>
    ";
    foreach($customers as $c)
    {
      echo"
        <tr>
          <th scope='row'><button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal' data-whatever='@mdo' id='customerEditButton_{$c['id']}'>Edit</button>
          <td>{$c['firstName']}</td>
          <td>{$c['lastName']}</td>
          <td>{$c['email']}</td>
          <td>{$c['address1']}</td>
          <td>{$c['address2']}</td>
          <td>{$c['city']}</td>
          <td>{$c['state']}</td>
          <td>{$c['zip']}</td>
          <td>{$this->formatPhoneNumber($c['areaCode'], $c['phonePrefix'], $c['phoneLineNumber'])}</td>
          <td>{$this->bool2txt($c['promotionEmail'])}</td>
          <td>{$this->bool2txt($c['promotionText'])}</td>
          <td>{$this->bool2txt($c['appointmentAlert'])}</td>
        </tr>
      ";
    }
    echo" 
      </tbody>
    </table>
    ";
  }
}
