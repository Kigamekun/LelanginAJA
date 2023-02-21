class BannerLelangin {
  final String id;

  final String thumb;

  BannerLelangin({required this.id, required this.thumb});

  factory BannerLelangin.fromJson(Map<String, dynamic> json) {
    return BannerLelangin(
      id: json["id"].toString(),
      thumb: json["thumb"],
    );
  }
}
