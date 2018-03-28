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

  public function list()
  {
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
          <th scope='row'><button type='button' class='btn btn-dark' id='customerEditButton_{$c['id']}'>Edit</button></th>
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
