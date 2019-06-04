import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { UserMasterComponent } from "./user-master/user-master.component";
import { UserListingComponent } from "./user-listing/user-listing.component";

const routes: Routes = [
  {
    path: 'listing',
    component: UserListingComponent
  },
  {
    path: 'master/:userId',
    component: UserMasterComponent
  },
  {
    path: 'master',
    component: UserMasterComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class UsersRoutingModule { }
