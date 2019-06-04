import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';

import { ConstantsService } from "../../services/constants.service";
import { UserService } from "../../services/user.service";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-change-password',
  templateUrl: './change-password.component.html',
  styleUrls: ['./change-password.component.css']
})
export class ChangePasswordComponent implements OnInit {

  /* Variable declaration starts */
  changePasswordForm: FormGroup;
  submitted = false;

  confirmPasswordFlag = false;
  /* Variable declaration ends */

  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private constantsService: ConstantsService,
    private userService: UserService,
    private spinner: NgxSpinnerService,
  ) { }

  ngOnInit() {

    this.changePasswordForm = this.formBuilder.group({
      password: ['', [Validators.required, Validators.minLength(5)]],
      confirmPassword: ['', [Validators.required, Validators.minLength(5)]]
    });
  }

  // convenience getter for easy access to form fields
  get f() { return this.changePasswordForm.controls; }

  onSubmit() {
    this.submitted = true;
    this.confirmPasswordFlag = false;

    // stop here if form is invalid
    if (this.changePasswordForm.invalid) {
      return;
    }

    let data = this.changePasswordForm.value;
    if( data.password != data.confirmPassword ) {
      this.confirmPasswordFlag = true;
      return;
    }

    data.id = this.constantsService.user.id;
    delete data.confirmPassword;
    
    this.spinner.show();
    this.userService.updateUser( data )
      .subscribe(
        result => {
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
            Swal.fire(
              'Password Changed!',
              'Password has been updated succesfully.',
              'success'
            );
            this.spinner.hide();
            this.router.navigate(['/dashboard']);
          }
        },
        error => {
          this.spinner.hide();
          console.log('error');
          console.log(error);
          Swal.fire({
            type: 'error',
            title: 'Oops...',
            text: error
          });
        }
    );
  }
}
