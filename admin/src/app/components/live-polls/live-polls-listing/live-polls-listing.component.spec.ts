import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LivePollsListingComponent } from './live-polls-listing.component';

describe('LivePollsListingComponent', () => {
  let component: LivePollsListingComponent;
  let fixture: ComponentFixture<LivePollsListingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LivePollsListingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LivePollsListingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
