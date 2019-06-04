import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HttpClientModule } from '@angular/common/http';

import { SharedModule } from "../shared/shared.module";

import { VotedPollsRoutingModule } from './voted-polls-routing.module';
import { VotedPollsListingComponent } from './voted-polls-listing/voted-polls-listing.component';

@NgModule({
  declarations: [VotedPollsListingComponent],
  imports: [
    CommonModule,
    VotedPollsRoutingModule,
    SharedModule,
    HttpClientModule,
  ]
})
export class VotedPollsModule { }
