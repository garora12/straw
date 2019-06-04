import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { PollsListingComponent } from "./polls-listing/polls-listing.component";
import { PollMasterComponent } from "./poll-master/poll-master.component";

const routes: Routes = [
  {
    path: 'listing',
    component: PollsListingComponent
  },
  {
    path: 'master/:pollId',
    component: PollMasterComponent
  },
  {
    path: 'master',
    component: PollMasterComponent
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PollsRoutingModule { }
