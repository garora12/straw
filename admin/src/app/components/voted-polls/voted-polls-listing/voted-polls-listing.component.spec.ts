import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { VotedPollsListingComponent } from './voted-polls-listing.component';

describe('VotedPollsListingComponent', () => {
  let component: VotedPollsListingComponent;
  let fixture: ComponentFixture<VotedPollsListingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ VotedPollsListingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(VotedPollsListingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
