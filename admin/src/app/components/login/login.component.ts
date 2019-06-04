import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import { NgxSpinnerService } from 'ngx-spinner';
import { ConstantsService } from "../../services/constants.service";
import { LoginService } from "../../services/login.service";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  submitted = false;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private loginService: LoginService,
    private constantsService: ConstantsService,
    private spinner: NgxSpinnerService
  ) {}

  ngOnInit() {

    this.loginForm = this.formBuilder.group({
      universityEmail: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(5)]]
    });
  }

  // convenience getter for easy access to form fields
  get f() { return this.loginForm.controls; }

  onSubmit() {
      this.submitted = true;

      // stop here if form is invalid
      if (this.loginForm.invalid) {
        return;
      }

      this.spinner.show();

      let in_data = this.loginForm.value;
      this.loginService.login( in_data )
        .subscribe(
          result => {

            this.spinner.hide();

            if( result.errorArr.length > 0) {
              if( result.error.tokenError ) {
                this.router.navigate(['/login']);
                Swal.fire({
                  type: 'error',
                  title: result.error.tokenError.toString(),
                  text: result.error.tokenError.toString()
                });
              } else {
                Swal.fire({
                  type: 'error',
                  title: result.errorArr.toString(),
                  text: result.errorArr.toString()
                });
              }
            } else {

              if( result.data.user.id == 1 ) {

                localStorage.setItem('currentUser', JSON.stringify({ 
                  token: result.data.token,
                  user: result.data.user
                }));

                this.constantsService.setLocalStorage();
                this.router.navigate(['/dashboard']);
                // this.router.navigate(['/users/listing']);
              } else {
                localStorage.removeItem('currentUser');
                Swal.fire(
                  'Access Denied!',
                  'Access denied. Only admin user can access!',
                  'info'
              );
              }
            }
          },
          error => {
            this.spinner.hide();
            console.log('error');
            console.log(error);
            Swal.fire({
              type: 'error',
              title: error,
              text: error
            });
          }
      );
  }
}
