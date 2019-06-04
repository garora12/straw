import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { LivePollsListingComponent } from "./live-polls-listing/live-polls-listing.component";

const routes: Routes = [
  {
    path: 'listing',
    component: LivePollsListingComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class LivePollsRoutingModule { }
