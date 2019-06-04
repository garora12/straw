import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import { LoginService } from "../../services/login.service";
import Swal from 'sweetalert2';
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.css']
})
export class ForgotPasswordComponent implements OnInit {

  forgotPasswordForm: FormGroup;
  submitted = false;

  constructor(
    private formBuilder: FormBuilder,
    private router: Router,
    private loginService: LoginService,
    private spinner: NgxSpinnerService
  ) { }

  ngOnInit() {

    this.forgotPasswordForm = this.formBuilder.group({
      universityEmail: ['', [Validators.required, Validators.email]]
    });
  }

  // convenience getter for easy access to form fields
  get f() { return this.forgotPasswordForm.controls; }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.forgotPasswordForm.invalid) {
      return;
    }
    this.spinner.show();

    let in_data = this.forgotPasswordForm.value;
    this.loginService.forgotPassword( in_data )
        .subscribe(
          result => {
            this.spinner.hide();
            console.log(result);
            if( result.errorArr.length ) {
              
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
              Swal.fire({
                type: 'success',
                title: result.message.toString(),
                text: result.message.toString()
              });
              this.router.navigate(['/login']);
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
