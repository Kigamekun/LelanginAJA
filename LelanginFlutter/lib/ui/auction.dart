import 'package:flutter/material.dart';
import 'dart:developer' as developer;
import 'package:lelanginaja/ui/detail.dart';
import 'package:lelanginaja/bloc/Product_bloc.dart';
import 'package:lelanginaja/model/Product.dart';
import 'package:lelanginaja/widget/appbarlelangin.dart';
import 'package:lelanginaja/widget/bottombarlelangin.dart';
import 'package:flutter_countdown_timer/current_remaining_time.dart';
import 'package:flutter_countdown_timer/flutter_countdown_timer.dart';

List list = [
  "Flutter",
  "React",
  "Ionic",
  "Xamarin",
];

class Auction extends StatefulWidget {
  final String query;
  const Auction({Key? key, required this.query}) : super(key: key);

  @override
  State<Auction> createState() => _AuctionState();
}

class _AuctionState extends State<Auction> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      resizeToAvoidBottomInset: false,
      body: ListView(children: [
        Column(children: [
          const AppBarLelangin(),
          Container(
              margin: const EdgeInsets.all(10),
              child: Wrap(
                children: [
                  FutureBuilder<List<Product>>(
                    future: widget.query != ''
                        ? fetchProduct(query: widget.query)
                        : fetchProduct(),
                    builder: (context, snapshot) {
                      if (snapshot.hasData) {
                        List<Product>? history = snapshot.data;
                        return Wrap(
                            children: history!
                                .map((post) => Wrap(
                                      children: <Widget>[
                                        Card(
                                          child: Row(
                                            crossAxisAlignment:
                                                CrossAxisAlignment.center,
                                            children: <Widget>[
                                              Image.network(
                                                post.thumb,
                                                height: 150,
                                                width: 100,
                                              ),
                                              Padding(
                                                padding:
                                                    const EdgeInsets.all(8.0),
                                                child: Column(
                                                  mainAxisSize:
                                                      MainAxisSize.min,
                                                  crossAxisAlignment:
                                                      CrossAxisAlignment.start,
                                                  children: <Widget>[
                                                    SizedBox(
                                                        width: MediaQuery.of(
                                                                    context)
                                                                .size
                                                                .width *
                                                            0.5,
                                                        child: Column(
                                                            children: <Widget>[
                                                              Text(
                                                                post.name,
                                                                maxLines: 3,
                                                                overflow:
                                                                    TextOverflow
                                                                        .ellipsis,
                                                                softWrap: false,
                                                                style: const TextStyle(
                                                                    color: Colors
                                                                        .black,
                                                                    fontWeight:
                                                                        FontWeight
                                                                            .bold,
                                                                    fontSize:
                                                                        10.0),
                                                              ),
                                                              const SizedBox(
                                                                  height: 10),
                                                              CountdownTimer(
                                                                endTime: DateTime.parse(
                                                                            post.end_auction)
                                                                        .millisecondsSinceEpoch +
                                                                    10 * 30,
                                                                widgetBuilder: (_,
                                                                    CurrentRemainingTime?
                                                                        time) {
                                                                  if (time ==
                                                                      null) {
                                                                    return Opacity(
                                                                        opacity:
                                                                            .3,
                                                                        child:
                                                                            Row(
                                                                          children: const [
                                                                            Icon(
                                                                              Icons.timer_outlined,
                                                                              size: 10,
                                                                            ),
                                                                            Text(
                                                                              'EXPIRED',
                                                                              style: TextStyle(fontSize: 10),
                                                                            )
                                                                          ],
                                                                        ));
                                                                  }
                                                                  return Opacity(
                                                                    opacity: .3,
                                                                    child: Row(
                                                                        children: [
                                                                          const Icon(
                                                                            Icons.timer_outlined,
                                                                            size:
                                                                                10,
                                                                          ),
                                                                          Text(
                                                                              '${time.days} d ${time.hours} h ${time.min} m ${time.sec} s',
                                                                              style: const TextStyle(fontSize: 10))
                                                                        ]),
                                                                  );
                                                                },
                                                              ),
                                                              const SizedBox(
                                                                  height: 20),
                                                              Row(
                                                                  crossAxisAlignment:
                                                                      CrossAxisAlignment
                                                                          .end,
                                                                  children: <
                                                                      Widget>[
                                                                    CountdownTimer(
                                                                      endTime: DateTime.parse(post.end_auction)
                                                                              .millisecondsSinceEpoch +
                                                                          10 *
                                                                              30,
                                                                      widgetBuilder: (_,
                                                                          CurrentRemainingTime?
                                                                              time) {
                                                                        if (time ==
                                                                            null) {
                                                                          return ElevatedButton(
                                                                            style:
                                                                                ElevatedButton.styleFrom(
                                                                              primary: const Color.fromARGB(255, 236, 72, 7), // background
                                                                              onPrimary: Colors.white, // foreground
                                                                            ),
                                                                            onPressed:
                                                                                () {
                                                                              developer.log('In Click');
                                                                              Navigator.push(context, MaterialPageRoute(builder: (context) => Details(id: post.id)));
                                                                            },
                                                                            child:
                                                                                const Text('Expired'),
                                                                          );
                                                                        }
                                                                        return ElevatedButton(
                                                                          style:
                                                                              ElevatedButton.styleFrom(
                                                                            primary:
                                                                                const Color(0xFF696cff), // background
                                                                            onPrimary:
                                                                                Colors.white, // foreground
                                                                          ),
                                                                          onPressed:
                                                                              () {
                                                                            developer.log('In Click');
                                                                            Navigator.push(context,
                                                                                MaterialPageRoute(builder: (context) => Details(id: post.id)));
                                                                          },
                                                                          child:
                                                                              const Text('Bid'),
                                                                        );
                                                                      },
                                                                    ),
                                                                    const SizedBox(
                                                                        width:
                                                                            10),
                                                                  ])
                                                            ])),
                                                  ],
                                                ),
                                              ),
                                            ],
                                          ),
                                        )
                                      ],
                                    ))
                                .toList());
                      }

                      return Center(
                        child: Column(
                          children: const <Widget>[
                            Padding(padding: EdgeInsets.all(50.0)),
                            CircularProgressIndicator(),
                          ],
                        ),
                      );
                    },
                  ),
                ],
              ))
        ])
      ]),
      bottomNavigationBar: BottomBarLelangin(active: 2),
    );
  }
}
