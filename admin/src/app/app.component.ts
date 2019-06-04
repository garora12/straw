import { Component, OnDestroy, Renderer2 } from '@angular/core';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { MessagingService } from "./services/messaging.service";

import { ConstantsService } from "./services/constants.service";

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnDestroy {
  title = 'straw-back';
  classLoginPage = false;
  message;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private messagingService: MessagingService,
    private constantsService: ConstantsService,
    private renderer: Renderer2
  ) {

    this.router.events.subscribe((ev) => {
      if (ev instanceof NavigationEnd) { /* Your code goes here on every router change */
        if( ev.url == '/' || ev.url == '/login' || ev.url == '/forgot-password' ) {
          this.classLoginPage = true;
          this.renderer.addClass(document.body, 'login-page');
        } else {
          this.renderer.removeClass(document.body, 'login-page');

          if( localStorage.getItem('currentUser') === null || localStorage.getItem('currentUser') === undefined ) {

            alert('Unathorised Access!');
            this.router.navigate(['/login']);
            return;
          } else {
          }
        }
      }
    });
  }

  ngOnInit() {
    this.messagingService.getPermission();
    this.messagingService.receiveMessage();
    this.message = this.messagingService.currentMessage;
  }

  ngOnDestroy() {
    this.renderer.removeClass(document.body, 'modal-open');
  }
}
