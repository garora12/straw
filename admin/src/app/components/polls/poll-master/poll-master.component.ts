import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { NgxSpinnerService } from 'ngx-spinner';
import Swal from 'sweetalert2';

import { ConstantsService } from "../../../services/constants.service";
import { OpenService } from "../../../services/open.service";
import { UserService } from "../../../services/user.service";
import { PollService } from "../../../services/poll.service";
import { findLast } from '@angular/compiler/src/directive_resolver';

@Component({
  selector: 'app-poll-master',
  templateUrl: './poll-master.component.html',
  styleUrls: ['./poll-master.component.css']
})
export class PollMasterComponent implements OnInit {

  /* Variable declaration starts */
  pollForm: FormGroup;
  submitted = false;
  signUpDataFlag = false;
  isImageExistsFlag = false;
  hiddenFormFieldsFlag = true;
  isPollIdProvidedFlag = false;
  isImageInvalid = false;
  enableSubmitButton = true;
  fileData: File = null;
  signUpData;
  pollId;
  usersList;
  pollData;
  imageUrl = this.constantsService.pollImageLink;
  headerTxt = 'Add Poll';
  buttonTxt = 'Submit';
  allowedFormats = [
    'image/png',
    'image/jpeg',
    'image/jpg'
  ]; 

  // testData = [];

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

  /* drop down branches */
  dropdownBranchList = [];
  selectedBranchItems = [];
  dropdownBranchSettings = {};
  selectedBranchItemsArr = [];

  /* drop down years */
  dropdownYearList = [];
  selectedYearItems = [];
  dropdownYearSettings = {};
  selectedYearItemsArr = [];

  /* drop down genders */
  dropdownGenderList = [];
  selectedGenderItems = [];
  dropdownGenderSettings = {};
  selectedGenderItemsArr = [];
  
  /* Variable declaration ends */


  /** multi level select starts */
  data: any;

  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private constantsService: ConstantsService,
    private openService: OpenService,
    private userService: UserService,
    private pollService: PollService,
    private spinner: NgxSpinnerService
  ) {

    this.data = {};
    this.data.isAllSelected = false;
    this.data.isAllCollapsed = false;
  }

  ngOnInit() {
    this.constantsService.setLocalStorage();

    this.setPollId();
    this.getGroupCountries();
    this.getAllUsers();

    this.pollForm = this.formBuilder.group({
      userId: ['', Validators.required],
      question: ['', Validators.required],
      allowComments: ['', Validators.required],
      // imageLink: ['', Validators.required]
      imageLink: '',
      genders: ['', Validators.required],
      // groupIds: ['', Validators.required],
      years: ['', Validators.required],
      countryIds: ['', Validators.required],
      branchIds: ['', Validators.required],
    });
  }

  getGroupCountries() {

    // this.spinner.show();
    this.openService.getSignUpData().subscribe(
      result => {

        // this.spinner.hide();
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

            //List object having hierarchy of parents and its children
          this.data.ParentChildchecklist = result.data.groupsCustom;
          
          console.log('------------------starting this.data.ParentChildchecklist------------------------');
          console.log('this.data.ParentChildchecklist', this.data.ParentChildchecklist);
          console.log('------------------ending this.data.ParentChildchecklist------------------------');
          
          // let out_data = [];

          /* let groupp = result.data.groupsNew;
          groupp.forEach(function(entry) {
            
            let obj = {
              id: entry.id,
              name: entry.name,
              parentId: entry.parentId
            };
            out_data.push(obj);

            let children = entry.children;
            children.forEach(ele => {
              
              let objChild = {
                id: ele.id,
                name: ele.name,
                parentId: ele.parentId
              };
              out_data.push(objChild);
            });
          }); */

          /* console.log('before this.dropdownGroupList', this.dropdownGroupList);
          this.dropdownGroupList = out_data;
          console.log('after this.dropdownGroupList', this.dropdownGroupList); */
          
          // this.testData = result.data.groupsNew;

          // this.dropdownGroupList = final;
          this.dropdownGroupSettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };

          // branches
          this.dropdownBranchList = result.data.branches;
          this.dropdownBranchSettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };

          // years
          this.dropdownYearList = [
            {
              id: 1,
              name: '1+'
            },
            {
              id: 2,
              name: '2+'
            },
            {
              id: 3,
              name: '3+'
            },
            {
              id: 4,
              name: '4+'
            }
          ];
          this.dropdownYearSettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };

          // genders
          this.dropdownGenderList = [
            {
              id: 'MALE',
              name: 'MALE'
            },
            {
              id: 'FEMALE',
              name: 'FEMALE'
            },
            {
              id: 'NEUTRAL',
              name: 'NEUTRAL'
            },
            {
              id: 'OTHER',
              name: 'OTHER'
            }
          ];
          this.dropdownGenderSettings = {
            singleSelection: false,
            idField: 'id',
            textField: 'name',
            selectAllText: 'Select All',
            unSelectAllText: 'UnSelect All',
            itemsShowLimit: 3,
            allowSearchFilter: true
          };
        }
      },
      error => {
        // this.spinner.hide();
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

  getAllUsers() {

    // this.spinner.show();
    this.userService.getAllUsers().subscribe(
      result => { 
        // this.spinner.hide();
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
          this.usersList = result.data;      
        }
      },
      error => {
        // this.spinner.hide();
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

  // convenience getter for easy access to form fields
  get f() { return this.pollForm.controls; }

  onSubmit() {

    this.submitted = true;

    // stop here if form is invalid
    if (this.pollForm.invalid) {
      return;
    }
    
    this.spinner.show();
    
    if( this.isPollIdProvidedFlag ) {
      this.updatePoll();
    } else {
      this.insertPoll();
    }
  }

  modifyPollPic() {

    if(  this.allowedFormats.indexOf( this.fileData.type ) == -1 ) {

      Swal.fire({
        type: 'info',
        title: 'Only PNG/JPEG/JPG files allowed!',
        text: 'Only PNG/JPEG/JPG files allowed!'
      });

      this.setInvalidImageErr( true );
      return;
    }

    this.setInvalidImageErr( false );

    this.spinner.show();
    this.pollService.modifyPollPic( this.pollData.userId, this.pollId, this.fileData ).subscribe(
      result => {
        this.spinner.hide();

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
            'Updated!',
            'Poll image has been updated succesfully.',
            'success'
          );
          this.imageUrl = this.constantsService.pollImageLink + result.data.poll.imageLink;
        }
      },
      error => {
        this.spinner.hide();
        console.log('error');
        console.log(error);
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: error,
          // footer: '<a href>Why do I have this issue?</a>'
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

    if( this.isPollIdProvidedFlag ) {
      this.modifyPollPic();
    }
  }

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
    this.pollForm.patchValue({
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
        this.pollForm.patchValue({
          countryIds: this.selectedCountryItemsArr,
        });
      } 
    } else {

      this.pollForm.patchValue({
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
    this.pollForm.patchValue({
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
        this.pollForm.patchValue({
          groupIds: this.selectedGroupItemsArr
        });
      } 
    } else {

      this.pollForm.patchValue({
        groupIds: this.selectedGroupItemsArr
      });
    }
  }

  onYearSelect(item: any, flag: boolean) {
    if( flag ) {
      if( this.selectedYearItemsArr.indexOf( item.id ) == -1 ) {
        this.selectedYearItemsArr.push( item.id );
      } 
    } else {      
      let index = this.selectedYearItemsArr.indexOf( item.id );
      if (index > -1) {
        this.selectedYearItemsArr.splice( index, 1 );
      }
    }
    this.pollForm.patchValue({
      years: this.selectedYearItemsArr,
    });
  }

  onYearSelectAll(items: any, flag: boolean) {
    this.selectedYearItemsArr = [];
    
    if( flag ) {
      
      if( items.length > 0 ) { 
        items.forEach( item => {
          if( this.selectedYearItemsArr.indexOf( item.id ) == -1 ) {
            this.selectedYearItemsArr.push( item.id );
          }
        });
        this.pollForm.patchValue({
          years: this.selectedYearItemsArr,
        });
      } 
    } else {

      this.pollForm.patchValue({
        years: this.selectedYearItemsArr,
      });
    }
  }

  onGenderSelect(item: any, flag: boolean) {
    if( flag ) {
      if( this.selectedGenderItemsArr.indexOf( item ) == -1 ) {
        this.selectedGenderItemsArr.push( item );
      } 
    } else {      
      let index = this.selectedGenderItemsArr.indexOf( item );
      if (index > -1) {
        this.selectedGenderItemsArr.splice( index, 1 );
      }
    }
    this.pollForm.patchValue({
      genders: this.selectedGenderItemsArr,
    });
  }

  onGenderSelectAll(items: any, flag: boolean) {
    this.selectedGenderItemsArr = [];
    
    if( flag ) {
      
      if( items.length > 0 ) { 
        items.forEach( item => {
          if( this.selectedGenderItemsArr.indexOf( item ) == -1 ) {
            this.selectedGenderItemsArr.push( item );
          }
        });
        this.pollForm.patchValue({
          genders: this.selectedGenderItemsArr,
        });
      } 
    } else {

      this.pollForm.patchValue({
        genders: this.selectedGenderItemsArr,
      });
    }
  }

  onBranchSelect(item: any, flag: boolean) {
    if( flag ) {
      if( this.selectedBranchItemsArr.indexOf( item.id ) == -1 ) {
        this.selectedBranchItemsArr.push( item.id );
      } 
    } else {      
      let index = this.selectedBranchItemsArr.indexOf( item.id );
      if (index > -1) {
        this.selectedBranchItemsArr.splice( index, 1 );
      }
    }
    this.pollForm.patchValue({
      branchIds: this.selectedBranchItemsArr,
    });
  }

  onBranchSelectAll(items: any, flag: boolean) {
    this.selectedBranchItemsArr = [];
    
    if( flag ) {
      
      if( items.length > 0 ) { 
        items.forEach( item => {
          if( this.selectedBranchItemsArr.indexOf( item.id ) == -1 ) {
            this.selectedBranchItemsArr.push( item.id );
          }
        });
        this.pollForm.patchValue({
          branchIds: this.selectedBranchItemsArr,
        });
      } 
    } else {

      this.pollForm.patchValue({
        branchIds: this.selectedBranchItemsArr,
      });
    }
  }

  getPollById() {
    
    this.spinner.show();
    this.pollService.getPollById( this.pollId ).subscribe(
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

          this.pollData = result.data;
          // this.imageUrl += this.pollData.poll.imageLink;
          this.imageUrl += this.pollData.imageLink;
          this.hiddenFormFieldsFlag = false;
          this.headerTxt = 'Edit Poll';
          this.buttonTxt = 'Update';

          if( this.pollData.imageLink == 'null' ) {
            
            this.isImageExistsFlag = false;  
          } else if( this.pollData.imageLink == '' ) {

            this.isImageExistsFlag = false;  
          } else {

            this.isImageExistsFlag = true;  
          }          

          let selectdGroupItemsChild = [];
          this.selectedGroupItems = this.pollData.groups.map( ( value, index, array ) => {

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

          this.selectedGroupItemsArr = this.selectedGroupItems.map( ( value, index, array ) => {
            return value.id
          } );
          
          // method to wait untill the parent Child Checklist is got set
          this.setPratentChildGroupDropDownData( this.selectedGroupItemsArr );
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

  setPollId() {

    this.route.params.subscribe( params => {    
      this.pollId = params.pollId;
      this.isPollIdProvidedFlag = this.pollId ? true : false;

      if( this.isPollIdProvidedFlag ) {
        this.getPollById();
      }
    });
  }

  setFormData() {
    this.pollForm.patchValue({
      userId: this.pollData.userId,
      question: this.pollData.question,
      allowComments: this.pollData.allowComments,
      genders: this.selectedGenderItemsArr,
      groupIds: this.selectedGroupItemsArr,
      years: this.selectedYearItemsArr,
      branchIds: this.selectedBranchItemsArr,
      countryIds: this.selectedCountryItemsArr
    });
  }

  formValues( data ) {

    this.spinner.show();

    let tmpCountryIds = data.countryIds.map( ( value, index, array ) => {
      return value;
    } );

    let tmpGenders = data.genders.map( ( value, index, array ) => {
      return value;
    } );

    let tmpBranches = data.branchIds.map( ( value, index, array ) => {
      return value;
    } );

    let tmpYears = data.years.map( ( value, index, array ) => {
      return value;
    } );

    let groupIds = this.getSelectedParentGroupIds();
    let tmpGroupIdsArr = groupIds.split(',');
    
    // let tmpGroupIds = data.groupIds.map( ( value, index, array ) => {
    //   return value;
    // } );

    tmpCountryIds.length == 246 ? tmpCountryIds = 'ALL' : tmpCountryIds = tmpCountryIds.join();
    tmpGroupIdsArr.length == 33 ? groupIds = 'ALL' : groupIds = groupIds;
    tmpGenders.length == 4 ? tmpGenders = 'ALL' : tmpGenders = tmpGenders.join();
    tmpYears.length == 4 ? tmpYears = 'ALL' : tmpYears = tmpYears.join();
    tmpBranches.length == 5 ? tmpBranches = 'ALL' : tmpBranches = tmpBranches.join();

    let tmpData = {
      id: this.pollId,
      userId: data.userId,
      question: data.question,
      allowComments: data.allowComments,
      imageLink: data.imageLink,
      branchIds: tmpBranches,
      years: tmpYears,
      genders: tmpGenders,
      countryIds: tmpCountryIds,
      groupIds: groupIds
    };

    this.isPollIdProvidedFlag ? '' : delete tmpData.id;
    this.spinner.hide();

    return tmpData;
  }

  insertPoll() {
    let data = this.pollForm.value;

    this.spinner.show();
    this.pollService.insertPoll( this.formValues( data ), this.fileData )
      .subscribe(
        result => {
          this.spinner.hide();

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
              'Poll Created!',
              'New poll has been created succesfully.',
              'success'
            );
            this.router.navigate(['/polls/listing']);
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

  updatePoll() {
    let data = this.pollForm.value;
    
    data.id = this.pollId;
    delete data.imageLink;

    this.spinner.show();
    this.pollService.updatePoll( this.formValues( data ) )
      .subscribe(
        result => {

          this.spinner.hide();
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
            // alert(result.message.toString());
            Swal.fire(
              'Poll Updated!',
              'Poll has been updated succesfully.',
              'success'
            );
            this.router.navigate(['/polls/listing']);            
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

  /** multi group methods starts here */
  //Click event on parent checkbox  
  parentCheck(parentObj) {
    for (var i = 0; i < parentObj.childList.length; i++) {
      parentObj.childList[i].isSelected = parentObj.isSelected;
    }
  }
 
  //Click event on child checkbox  
  childCheck(parentObj, childObj) {
    parentObj.isSelected = childObj.every(function (itemChild: any) {
      return itemChild.isSelected == true;
    })
  }
 
  //Click event on master select
  selectUnselectAll(obj) {
    obj.isAllSelected = !obj.isAllSelected;
    for (var i = 0; i < obj.ParentChildchecklist.length; i++) {
      obj.ParentChildchecklist[i].isSelected = obj.isAllSelected;
      for (var j = 0; j < obj.ParentChildchecklist[i].childList.length; j++) {
        obj.ParentChildchecklist[i].childList[j].isSelected = obj.isAllSelected;
      }
    }
  }
 
  //Expand/Collapse event on each parent
  expandCollapse(obj){
    obj.isClosed = !obj.isClosed;
  }
 
  //Master expand/ collapse event
  expandCollapseAll(obj){
    for (var i = 0; i < obj.ParentChildchecklist.length; i++) {
      obj.ParentChildchecklist[i].isClosed = !obj.isAllCollapsed;
    }
    obj.isAllCollapsed = !obj.isAllCollapsed;
  }
  /** multi groups methods ends here */

  setChild( in_data, position ) {

    in_data.forEach(element => {
      let parentPos = this.data.ParentChildchecklist[position].childList.map(function(e) { return e.id; }).indexOf( element );
      if( parentPos !== -1 && this.data.ParentChildchecklist[position].childList[parentPos].id == element ) {
        this.data.ParentChildchecklist[position].childList[parentPos].isSelected = true;
      }
    });
  }

  setPratentChildGroupDropDownData( in_data ) {

    // dont set the form untill the parent Child Checklist is not set
    if( typeof this.data.ParentChildchecklist === 'undefined' ) {

      setTimeout(() => {

        this.setPratentChildGroupDropDownData( in_data );
      }, 1000);
    } else {

      // set parent child checked
      in_data.forEach(element => {
        
        let parentPos = this.data.ParentChildchecklist.map(function(e) { return e.id; }).indexOf( element );
        
        if( parentPos !== -1 && this.data.ParentChildchecklist[parentPos].id == element ) {
  
          this.data.ParentChildchecklist[parentPos].isSelected = true;
  
          this.setChild( in_data, parentPos );
        } 
      });

      // set countryItems checked
      this.selectedCountryItems = this.pollData.countries.map( ( value, index, array ) => {
        return {
          id: value.countryId,
          name: value.countryName,
        };
      } );

      // set countryItems array checked
      this.selectedCountryItemsArr = this.pollData.countries.map( ( value, index, array ) => {
        return value.countryId;
      } );
      
      // set yearItems checked
      this.selectedYearItems = this.pollData.years.map( ( value, index, array ) => {
        return {
          id: value,
          name: value,
        };
      } );
      
      // set yearItems array checked
      this.selectedYearItemsArr = this.pollData.years.map( ( value, index, array ) => {
        return value
      } );
      
      // set genderItems checked
      this.selectedGenderItems = this.pollData.genders.map( ( value, index, array ) => {
        return {
          id: value,
          name: value,
        };
      } );

      // set genderItems array checked      
      this.selectedGenderItemsArr = this.pollData.genders.map( ( value, index, array ) => {
        return value
      } );
      
      // set branchItems checked      
      this.selectedBranchItems = this.pollData.branches.map( ( value, index, array ) => {
        return {
          id: value.branchId,
          name: value.branchName,
        };
      } );

      // set genderItems array checked            
      this.selectedBranchItemsArr = this.pollData.branches.map( ( value, index, array ) => {
        return value.branchId
      } );

      // when all set now call the setFormData method
      this.setFormData();
      this.spinner.hide();
    }
  }
  
  getSelectedParentGroupIds() {

    let parentIds = '';
    let childIds = '';

    let parentIdsArr = [];
    let childIdsArr = [];

    console.log('this.data.ParentChildchecklist.length', this.data.ParentChildchecklist.length);
    console.log('this.data.ParentChildchecklist', this.data.ParentChildchecklist);

    for( let i = 0; i < this.data.ParentChildchecklist.length; i++ ) {

      if( this.data.ParentChildchecklist[i].isSelected ) {

        if( parentIdsArr.indexOf( this.data.ParentChildchecklist[i].id ) == -1 ) {

          parentIds += this.data.ParentChildchecklist[i].id +',';
          parentIdsArr.push( this.data.ParentChildchecklist[i].id );
        }

        for( let j = 0; j < this.data.ParentChildchecklist[i].childList.length; j++ ) {

          if( this.data.ParentChildchecklist[i].childList[j].isSelected ) {

            if( parentIdsArr.indexOf( this.data.ParentChildchecklist[i].childList[j].id ) == -1 ) {
              
              childIds += this.data.ParentChildchecklist[i].childList[j].id +',';
              childIdsArr.push( this.data.ParentChildchecklist[i].childList[j].id );
            }            
          }
        }
      } else {

        // if the parent is not selected but its child selected add the parent to the in_data which would be send to the server
        for( let j = 0; j < this.data.ParentChildchecklist[i].childList.length; j++ ) {

          if( this.data.ParentChildchecklist[i].childList[j].isSelected ) {

            if( parentIdsArr.indexOf( this.data.ParentChildchecklist[i].id ) == -1 ) {

              parentIds += this.data.ParentChildchecklist[i].id +',';
              parentIdsArr.push( this.data.ParentChildchecklist[i].id );
            }

            if( parentIdsArr.indexOf( this.data.ParentChildchecklist[i].childList[j].id ) == -1 ) {
              
              childIds += this.data.ParentChildchecklist[i].childList[j].id +',';
              childIdsArr.push( this.data.ParentChildchecklist[i].childList[j].id );
            }
          }
        }
      }
    }

    let groupIds = parentIds + childIds.replace(/,\s*$/, "");
    return groupIds;
  }

  deletePollImageByPollIdApi() {
    
    this.spinner.show();
    this.pollService.deletePollImageByPollId( this.pollId ).subscribe(
      result => {

        this.spinner.hide();
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
            'Poll Image Deleted!',
            'Poll Image has been deleted succesfully.',
            'success'
          );
          this.router.navigate(['/polls/listing']);
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

  deletePollImageByPollId() {

    Swal.fire({
      title: 'Are you sure to delete this image?',
      // text: "You won't be able to revert this!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        this.deletePollImageByPollIdApi();
      }
    });
  }
}
