import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { PollService } from "../../../services/poll.service";
import { NgxSpinnerService } from 'ngx-spinner';
import { ConstantsService } from "../../../services/constants.service";
import Swal from 'sweetalert2';

@Component({
  selector: 'app-live-polls-listing',
  templateUrl: './live-polls-listing.component.html',
  styleUrls: ['./live-polls-listing.component.css']
})
export class LivePollsListingComponent implements OnInit {

  public polls;
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
    private pollService: PollService,
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
    this.getLivePollListing( 0 );
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

      this.getLivePollListing( offset );
    } else {
      this.currentPage--;  
    }
  }

  prev() {

    let offset = ((this.currentPage - 1) - 1) * this.limit;
    this.currentPage--;

    if( this.currentPage > 0 ) {

      this.getLivePollListing( offset );
    } else {
      this.currentPage++;
    }
  }

  first() {
    this.currentPage = 1;
    this.getLivePollListing( 0 );
  }

  last() {
    
    let offset = ((this.totalPages - 1) * this.limit);
    this.currentPage = this.totalPages;
    this.getLivePollListing( offset );
  }

  search( e ) {

    this.searchTxt = e.target.value;
    this.offset = 0;
    this.in_data = {
      search: this.searchTxt,
      offset: this.offset,
      limit: this.limit
    };
    this.getLivePollListing( this.offset );
  }

  getLivePollListing( offset ) {

    this.in_data = {
      search: this.searchTxt,
      offset: offset,
      limit: this.limit
    };

    this.pollService.getLivePollListing( this.in_data ).subscribe(
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

          console.log('result');
          console.log(result);
          this.polls = '';
          this.totalRecords = 0;
          this.polls = result.data.polls;
          this.totalRecords = result.data.totalPolls;
          this.generatePagination( this.in_data );
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
