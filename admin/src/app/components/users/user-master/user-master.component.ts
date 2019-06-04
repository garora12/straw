import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import Swal from 'sweetalert2';

import { ConstantsService } from "../../../services/constants.service";
import { OpenService } from "../../../services/open.service";
import { UserService } from "../../../services/user.service";

@Component({
  selector: 'app-user-master',
  templateUrl: './user-master.component.html',
  styleUrls: ['./user-master.component.css']
})
export class UserMasterComponent implements OnInit {

  /* Variable declaration starts */
  userForm: FormGroup;
  submitted = false;
  signUpDataFlag = false;
  signUpData;
  fileData: File = null;
  isUserIdProvidedFlag = false;
  isImageInvalid = false;
  enableSubmitButton = true;
  userId;
  userData;
  isImageExistsFlag = false;
  hiddenFormFieldsFlag = true;
  imageUrl = this.constantsService.userImageLink;
  headerTxt = 'Add User';
  buttonTxt = 'Submit';
  allowedFormats = [
    'image/png',
    'image/jpeg',
    'image/jpg'
  ];


  /* drop down countries */
  dropdownCountryList = [];
  selectedCountryItems = [];
  dropdownCountrySettings = {};
  selectedCountryItemsArr = [];

  /* drop down groups */
  dropdownGroupList = [];
  selectedGroupItems = [];
  dropdownGroupSettings = {};
  selectedGroupItemsArr = [];
  /* Variable declaration ends */

  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private constantsService: ConstantsService,
    private openService: OpenService,
    private userService: UserService,
    private spinner: NgxSpinnerService
  ) { }

  ngOnInit() {
    this.spinner.show();
    this.constantsService.setLocalStorage();

    this.setUserId();
    this.openService.getSignUpData().subscribe(
      result => {
        if( result.errorArr.length ) {
          alert(result.errorArr.toString());
        } else {
          this.signUpData = result.data;
          this.signUpDataFlag = true;

          // countries
          this.dropdownCountryList = result.data.countries;
          this.dropdownCountrySettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };

          // groups
          this.dropdownGroupList = result.data.groups;
          this.dropdownGroupSettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };

          this.spinner.hide();
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
    
    if( this.isUserIdProvidedFlag ) {

      this.userForm = this.formBuilder.group({
        userName: ['', Validators.required],
        universityEmail: ['', [Validators.required, Validators.email]],
        // password: ['', [Validators.required, Validators.minLength(5)]],
        password: '',
        gender: ['', Validators.required],
        studyingYear: ['', Validators.required],
        countryIds: ['', Validators.required],
        // countryIds: new FormControl(['', Validators.required]),      
        branchId: ['', Validators.required],
        groupIds: ['', Validators.required],
        // imageLink: ['', Validators.required]
        imageLink: ''
      });
    } else {

      this.userForm = this.formBuilder.group({
        userName: ['', Validators.required],
        universityEmail: ['', [Validators.required, Validators.email]],
        password: ['', [Validators.required, Validators.minLength(5)]],
        // password: '',
        gender: ['', Validators.required],
        studyingYear: ['', Validators.required],
        countryIds: ['', Validators.required],
        // countryIds: new FormControl(['', Validators.required]),      
        branchId: ['', Validators.required],
        groupIds: ['', Validators.required],
        // imageLink: ['', Validators.required]
        imageLink: ''
      });
    }
  }

  // convenience getter for easy access to form fields
  get f() { return this.userForm.controls; }

  onCountrySelect(item: any, flag: boolean) {
    if( flag ) {
      if( this.selectedCountryItemsArr.indexOf( item.id ) == -1 ) {
        this.selectedCountryItemsArr.push( item.id );
      } 
    } else {      
      let index = this.selectedCountryItemsArr.indexOf( item.id );
      if (index > -1) {
        this.selectedCountryItemsArr.splice( index, 1 );
      }
    }
    this.userForm.patchValue({
      countryIds: this.selectedCountryItemsArr,
    });
  }

  onCountrySelectAll(items: any, flag: boolean) {
    this.selectedCountryItemsArr = [];
    
    if( flag ) {
      
      if( items.length > 0 ) { 
        items.forEach( item => {
          if( this.selectedCountryItemsArr.indexOf( item.id ) == -1 ) {
            this.selectedCountryItemsArr.push( item.id );
          }
        });
        this.userForm.patchValue({
          countryIds: this.selectedCountryItemsArr,
        });
      } 
    } else {

      this.userForm.patchValue({
        countryIds: this.selectedCountryItemsArr,
      });
    }
  }

  onGroupSelect(item: any, flag: boolean) {
    if( flag ) {
      if( this.selectedGroupItemsArr.indexOf( item.id ) == -1 ) {
        this.selectedGroupItemsArr.push( item.id );
      } 
    } else {      
      let index = this.selectedGroupItemsArr.indexOf( item.id );
      if (index > -1) {
        this.selectedGroupItemsArr.splice( index, 1 );
      }
    }
    this.userForm.patchValue({
      groupIds: this.selectedGroupItemsArr,
    });
  }

  onGroupSelectAll(items: any, flag: boolean) {
    this.selectedGroupItemsArr = [];
    
    if( flag ) {
      
      if( items.length > 0 ) { 
        items.forEach( item => {
          if( this.selectedGroupItemsArr.indexOf( item.id ) == -1 ) {
            this.selectedGroupItemsArr.push( item.id );
          }
        });
        this.userForm.patchValue({
          groupIds: this.selectedGroupItemsArr
        });
      } 
    } else {

      this.userForm.patchValue({
        groupIds: this.selectedGroupItemsArr
      });
    }
  }

  setUserId() {

    this.route.params.subscribe( params => {      
      this.userId = params.userId;
      this.isUserIdProvidedFlag = this.userId ? true : false;

      if( this.isUserIdProvidedFlag ) {
        this.getUserById();
      }
    });
  }

  getUserById() {

    this.spinner.show();
    this.userService.getUserById( this.userId ).subscribe(
      result => {

        if( result.errorArr.length > 0 ) {
          
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
		      this.spinner.hide();
		  		  
        } else {

          this.userData = result.data;
          this.imageUrl += this.userData.imageLink;
          this.hiddenFormFieldsFlag = false;
          this.headerTxt = 'Edit User';
          this.buttonTxt = 'Update';
          this.isImageExistsFlag = this.userData.imageLink != '' && this.userData.imageLink != null ? true : false;

          this.selectedCountryItems = this.userData.countries.map( ( value, index, array ) => {
            return {
              id: value.countryId,
              name: value.countryName,
            };
          } );

          this.selectedCountryItemsArr = this.userData.countries.map( ( value, index, array ) => {
            return value.countryId;
          } );
          
          let selectdGroupItemsChild = [];
          this.selectedGroupItems = this.userData.groups.map( ( value, index, array ) => {

            if( typeof value.children != 'undefined' ) {

              value.children.forEach(element => {
                selectdGroupItemsChild.push({
                  id: element.groupId,
                  name: element.groupName,
                });
              });
            }

            return {
              id: value.groupId,
              name: value.groupName,
            };
          } );

          this.selectedGroupItems = this.selectedGroupItems.concat( selectdGroupItemsChild );

          this.selectedGroupItemsArr = this.userData.groups.map( ( value, index, array ) => {
            return value.groupId
          } );
          this.setFormData();
          this.spinner.hide();
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

  formValues( data ) {

    let tmpCountryIds = data.countryIds.map( ( value, index, array ) => {
      return value;
    } );

    let tmpGroupIds = data.groupIds.map( ( value, index, array ) => {
      return value;
    } );

    tmpCountryIds.length == 246 ? tmpCountryIds = 'ALL' : tmpCountryIds = tmpCountryIds.join();
    tmpGroupIds.length == 33 ? tmpGroupIds = 'ALL' : tmpGroupIds = tmpGroupIds.join();

    let tmpData = {
      id: this.userId,
      userName: data.userName,
      universityEmail: data.universityEmail,
      studyingYear: data.studyingYear,
      password: data.password,
      imageLink: data.imageLink,
      gender: data.gender,
      branchId: data.branchId,
      // countryIds: data.countryIds.length > 0 ? tmpCountryIds.join() : '',
      // groupIds: data.groupIds.length > 0 ? tmpGroupIds.join() : ''
      countryIds: tmpCountryIds,
      groupIds: tmpGroupIds
    };

    this.isUserIdProvidedFlag ? '' : delete tmpData.id;
    return tmpData;
  }

  insertUser() {
    let data = this.userForm.value;
    this.spinner.show();
    this.userService.insertUser( this.formValues( data ), this.fileData )
      .subscribe(
        result => {
          console.log(result);
          if( result.errorArr.length > 0 ) {
            
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
              'User Created!',
              'New user has been created succesfully.',
              'success'
            );
            this.router.navigate(['/users/listing']);
          }
          this.spinner.hide();
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

  updateUser() {

    this.spinner.show();
    let data = this.userForm.value;
    
    data.id = this.userId;
    delete data.imageLink;

    if( !data.password ) {
      delete data.password;
    }

    this.userService.updateUser( this.formValues( data ) )
      .subscribe(
        result => {
          
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
            Swal.fire(
              'User Updated!',
              'User has been updated succesfully.',
              'success'
            );
            this.router.navigate(['/users/listing']);            
          }
          this.spinner.hide();
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

  modifyUserProfilePic() {
    this.spinner.show();

    if(  this.allowedFormats.indexOf( this.fileData.type ) == -1 ) {
      // this.fileData = null;
      // alert('Only PNG/JPEG/JPG files allowed!');
      this.setInvalidImageErr( true );
      this.spinner.hide();
      return;
    }
    
    this.setInvalidImageErr( false );

    this.userService.modifyUserProfilePic( this.userId, this.fileData ).subscribe(
      result => {
        console.log(result);

        if( result.errorArr.length > 0 ) {
          
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
          this.isImageExistsFlag = true;
          Swal.fire(
            'Profile Pic Updated!',
            'User has been updated succesfully.',
            'success'
          );
          this.imageUrl = this.constantsService.userImageLink + result.data.user.imageLink;
        }
        this.spinner.hide();
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

  onChange(event: any) {
    this.fileData = <File>event.target.files[0];

    if(  this.allowedFormats.indexOf( this.fileData.type ) == -1 ) {
      
      this.setInvalidImageErr( true );
      return;
    }

    this.setInvalidImageErr( false );

    if( this.isUserIdProvidedFlag ) {
      this.modifyUserProfilePic();
    }
  }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.userForm.invalid) {
      return;
    }

    let data = this.userForm.value;
    let universityEmail = data.universityEmail;

    var res = universityEmail.split("@");
    if( res[1] != 'co.uk' ) {

      Swal.fire({
        type: 'info',
        title: 'Invalid Email, Only co.uk emails allowed!',
        text: 'Invalid Email, Only co.uk emails allowed!'
      });
      return;
    }
    
    if( this.isUserIdProvidedFlag ) {
      this.updateUser();
    } else {
      this.insertUser();
    }
  }

  setFormData() {
    this.userForm.patchValue({
      userName: this.userData.userName,
      universityEmail: this.userData.universityEmail,
      gender: this.userData.gender,
      studyingYear: this.userData.studyingYear,
      branchId: this.userData.branchId,
      countryIds: this.selectedCountryItemsArr,
      groupIds: this.selectedGroupItemsArr
    });
  }

  setInvalidImageErr( flag ) {

    if( flag ) {

      this.fileData = null;
      this.isImageInvalid = true;
      this.enableSubmitButton = false;

      Swal.fire({
        type: 'info',
        title: 'Only PNG/JPEG/JPG files allowed!',
        text: 'Only PNG/JPEG/JPG files allowed!'
      });
    } else {

      this.isImageInvalid = false;
      this.enableSubmitButton = true;
    }
  }
}
