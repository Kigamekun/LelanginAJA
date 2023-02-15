import 'dart:developer' as developer;

class BannerLelangin {
  final String id;

  final String thumb;

  BannerLelangin({required this.id, required this.thumb});

  factory BannerLelangin.fromJson(Map<String, dynamic> json) {
    // developer.inspect(json);
    return BannerLelangin(
      id: json["id"].toString(),
      thumb: json["thumb"],
    );
  }
}
