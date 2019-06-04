import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

import { UserService } from "../../../services/user.service";
import { NgxSpinnerService } from 'ngx-spinner';
import { ConstantsService } from "../../../services/constants.service";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-user-listing',
  templateUrl: './user-listing.component.html',
  styleUrls: ['./user-listing.component.css']
})
export class UserListingComponent implements OnInit {

  public users;
  public searchTxt = '';

  // pagination
  public offset = 0;
  public limit = 5;
  public totalRecords = 0;
  public totalPages = 0;
  public pageNo = 0;
  public prevPage = 0;
  public nextPage = 0;
  public firstPage = 0;
  public lastPage = 0;
  public activePage = 0;
  public currentPage = 1;
  public maxPage = 0;
  public minPage = 0;
  public showPagination = false;
  public in_data;

  constructor(
    private router: Router,
    private userService: UserService,
    private spinner: NgxSpinnerService,
    private constantsService: ConstantsService
  ) {

    this.limit = this.constantsService.paginationLimit;
    this.totalRecords = 0;

    this.in_data = {
      search: this.searchTxt,
      offset: this.offset,
      limit: this.limit
    };
  }

  ngOnInit() {
    this.spinner.show();
    this.constantsService.setLocalStorage();
    this.getUserListing( 0 );
    // this.generatePagination( 0 );
  }

  createRange( number ) {
    var items: number[] = [];
    for( var i = 1; i <= number; i++ ) {
      items.push(i);
    }
    return items;
  }

  generatePagination( in_data ) {

    this.showPagination = true;

    let offset = in_data.offset;
    this.totalPages = Math.ceil(this.totalRecords / this.limit);

    this.offset = this.limit * offset;
    this.firstPage = 0;
    this.lastPage = this.totalPages;

    this.in_data = {
      search: this.searchTxt,
      offset: this.offset,
      limit: this.limit
    };
  }

  next() {

    let offset = ((this.currentPage + 1) - 1) * this.limit;
    this.currentPage++;

    if( this.currentPage <= this.totalPages ) {

      this.getUserListing( offset );
    } else {
      this.currentPage--;  
    }
  }

  prev() {

    let offset = ((this.currentPage - 1) - 1) * this.limit;
    this.currentPage--;

    if( this.currentPage > 0 ) {

      this.getUserListing( offset );
    } else {
      this.currentPage++;
    }
  }

  first() {
    this.currentPage = 1;
    this.getUserListing( 0 );
  }

  last() {

    let offset = ((this.totalPages - 1) * this.limit);
    this.currentPage = this.totalPages;
    this.getUserListing( offset );
  }

  getUserListing( offset ) {

    this.in_data = {
      search: this.searchTxt,
      offset: offset,
      limit: this.limit
    };
    this.userService.getUserListing( this.in_data ).subscribe(
      result => {

        this.spinner.hide();
        
        if( result.errorArr.length > 0) {

          // this.showPagination = false;

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
          this.users = '';
          this.totalRecords = 0;
          this.users = result.data;
          this.totalRecords = result.cnt;
          this.generatePagination( this.in_data );
        }
      },
      error => {
        this.spinner.hide();
        console.log('error');
        console.log(error);
        this.showPagination = false;
        return [];
      }
    );
  }

  deleteUserByUserId( userId ) {
    this.spinner.show();

    this.userService.deleteUserByUserId( userId ).subscribe(
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
          this.getUserListing( this.in_data );
          Swal.fire(
            'Deleted!',
            'User has been deleted succesfully.',
            'success'
          );
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

  search( e ) {
    
    this.searchTxt = e.target.value;
    this.offset = 0;
    this.in_data = {
      search: this.searchTxt,
      offset: this.offset,
      limit: this.limit
    };
    this.getUserListing( this.offset );
  }

  softDelete( userId ) {

    Swal.fire({
      title: 'Are you sure to delete this user?',
      // text: "You won't be able to revert this!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.value) {
        this.deleteUserByUserId( userId );
      }
    });
  }

  blockUnblockUser( userId, in_status ) {

    let statusTxt = in_status == 'BLOCKED' ? 'Blocked' : 'Unblocked';

    let in_data = {
      id: userId,
      status: in_status
    };
    this.spinner.show();
    
    this.userService.updateUser( in_data ).subscribe(
      result => {

        this.spinner.hide();
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
          this.getUserListing( this.in_data );
          // alert(result.message.toString());          
          Swal.fire(
            'User '+ statusTxt,
            result.message.toString(),
            'success'
          );
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

  confirmBlockUnblockUser( userId, in_status ) {

    let statusTxt = in_status ? 'Block' : 'Unblock';
    let status = in_status ? 'BLOCKED' : 'OPEN';

    Swal.fire({
      title: `Are you sure to ${statusTxt} this user?`,
      // text: "You won't be able to revert this!",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.value) {
        this.blockUnblockUser( userId, status );
      }
    });
  }
}
