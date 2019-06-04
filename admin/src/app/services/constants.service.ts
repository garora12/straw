import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class ConstantsService {

  public baseUrl: string = `http://localhost:8080/straw-app`;
  // public baseUrl: string = `http://10.8.18.51/straw-app-staging`;
  // public baseUrl: string = `http://10.8.18.51/straw-app`;
  // public baseUrl: string = `http://203.100.79.185/straw-app`;
  // public baseUrl: string = `https://straw.blackcatzinc.com/straw-app-staging`;
  // public baseUrl: string = `https://straw.blackcatzinc.com/straw-app`;
    
  public userImageLink: string;
  public token: string;
  public user;
  public userProfilePic: string;
  public pollImageLink: string;
  public paginationLimit: number;

  constructor() {

    // this.baseUrl = `http://localhost:8080/straw-app`;
    // this.baseUrl = `http://10.8.18.51/straw-app-staging`;
    // this.baseUrl = `http://10.8.18.51/straw-app`;
    // this.baseUrl = `http://203.100.79.185/straw-app`;
    // this.baseUrl = `https://straw.blackcatzinc.com/straw-app-staging`;
    this.baseUrl = `https://straw.blackcatzinc.com/straw-app`;

    this.userImageLink = `${this.baseUrl}/storage/`;
    this.pollImageLink = `${this.baseUrl}/storage/polls/`;
    this.paginationLimit = 10;
  }

  setLocalStorage() {

    if ( localStorage.getItem("currentUser") === null || localStorage.getItem("currentUser") === undefined ) {
      
    } else {
      
      let user = JSON.parse( localStorage.getItem('currentUser') );
      this.user = user.user;
      this.token = user.token;
      this.userProfilePic = `${this.userImageLink}${this.user.imageLink}`;
    }
  }
}
