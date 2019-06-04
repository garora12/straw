import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { VotedPollsListingComponent } from "./voted-polls-listing/voted-polls-listing.component";

const routes: Routes = [
  {
    path: 'listing',
    component: VotedPollsListingComponent
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class VotedPollsRoutingModule { }
